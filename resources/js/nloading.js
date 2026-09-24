(() => {
    const initialize = () => {
        const root = document.getElementById('nloading-overlay');

        if (!root || root.dataset.nloadingInitialized === 'true') return;

        const config = JSON.parse(root.dataset.nloadingConfig ?? '{}');

        if (!config.enabled) return;

        root.dataset.nloadingInitialized = 'true';

        let activeOperations = 0;
        let showTimer = null;
        let navigationActive = false;

        const show = () => {
            if (!config.enabled) return;
            window.clearTimeout(showTimer);
            showTimer = window.setTimeout(() => {
                root.style.display = 'flex';
                root.setAttribute('aria-hidden', 'false');
            }, config.delay);
        };

        const hideIfIdle = () => {
            if (activeOperations > 0 || navigationActive) return;
            window.clearTimeout(showTimer);
            root.style.display = 'none';
            root.setAttribute('aria-hidden', 'true');
        };

        const begin = () => {
            activeOperations++;
            show();
        };

        const finish = () => {
            activeOperations = Math.max(0, activeOperations - 1);
            hideIfIdle();
        };

        if (config.navigation) {
            document.addEventListener('alpine:navigating', () => {
                navigationActive = true;
                show();
            });
            document.addEventListener('alpine:navigated', () => {
                navigationActive = false;
                hideIfIdle();
            });

            document.addEventListener('click', (event) => {
                const link = event.target.closest('a[href]');
                if (!link || event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || link.target || link.hasAttribute('download')) return;

                const destination = new URL(link.href, window.location.href);
                if (destination.origin !== window.location.origin || destination.href === window.location.href) return;

                navigationActive = true;
                show();
            }, true);

            window.addEventListener('pageshow', () => {
                navigationActive = false;
                hideIfIdle();
            });
        }

        if (!config.livewire.enabled) return;

        const componentIsPolling = (componentElement) => {
            const hasPollDirective = (element) => Array.from(element.attributes).some((attribute) => attribute.name.startsWith('wire:poll'));
            if (hasPollDirective(componentElement)) return true;

            return Array.from(componentElement.querySelectorAll('*')).some((element) => {
                if (!hasPollDirective(element)) return false;

                let owner = element;
                while (owner && owner !== componentElement && !owner.hasAttribute('wire:id')) owner = owner.parentElement;

                return owner === componentElement;
            });
        };

        document.addEventListener('livewire:init', () => {
            window.Livewire.hook('commit', ({ component, commit, succeed, fail }) => {
                const actionsExcluded = (commit.calls ?? []).some((call) => config.livewire.excludeActions.includes(call.method));
                const pollingIgnored = config.livewire.ignorePolling && componentIsPolling(component.el);

                if (actionsExcluded || pollingIgnored) return;

                begin();
                let finished = false;
                const finishOnce = () => {
                    if (finished) return;
                    finished = true;
                    finish();
                };

                succeed(finishOnce);
                fail(finishOnce);
            });
        }, { once: true });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialize, { once: true });
    } else {
        initialize();
    }
})();
