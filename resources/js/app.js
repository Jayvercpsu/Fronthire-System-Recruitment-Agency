import './bootstrap';

import AOS from 'aos';
import 'aos/dist/aos.css';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.AOS = AOS;

let hasInitializedAos = false;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    window.setTimeout(() => {
        document.body.classList.remove('page-enter');
    }, 420);

    initAosAnimations();
    initScrollspy();
    initBackToTop();
    initPageTransitions();
    initActionConfirmations();
    initFlashAlerts();
    initChatMessaging();
});

window.addEventListener('load', () => {
    if (!hasInitializedAos) {
        return;
    }

    AOS.refreshHard();
});

window.addEventListener('pageshow', () => {
    document.body.classList.remove('page-leaving');

    if (!hasInitializedAos) {
        return;
    }

    AOS.refreshHard();
});

function initAosAnimations() {
    const revealOnlyElements = document.querySelectorAll('[data-reveal]:not([data-aos])');

    revealOnlyElements.forEach((element, index) => {
        element.setAttribute('data-aos', 'fade-up');

        if (!element.hasAttribute('data-aos-duration')) {
            element.setAttribute('data-aos-duration', '860');
        }

        if (!element.hasAttribute('data-aos-delay')) {
            element.setAttribute('data-aos-delay', String((index % 6) * 60));
        }

        if (!element.hasAttribute('data-aos-anchor-placement')) {
            element.setAttribute('data-aos-anchor-placement', 'top-bottom');
        }
    });

    AOS.init({
        duration: 860,
        delay: 0,
        easing: 'cubic-bezier(0.16, 1, 0.3, 1)',
        once: false,
        mirror: true,
        offset: 24,
        disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
    });

    hasInitializedAos = true;

    window.requestAnimationFrame(() => {
        AOS.refreshHard();
    });
}

function initPageTransitions() {
    if (document.body?.dataset?.pageTransitions === 'off') {
        document.body.classList.remove('page-enter', 'page-leaving');
        return;
    }

    document.addEventListener(
        'click',
        (event) => {
            const link = event.target.closest('a[href]');

            if (!link) {
                return;
            }

            if (
                link.target === '_blank' ||
                event.defaultPrevented ||
                event.ctrlKey ||
                event.metaKey ||
                event.shiftKey ||
                event.altKey ||
                link.hasAttribute('download')
            ) {
                return;
            }

            const url = new URL(link.href, window.location.origin);
            const href = link.getAttribute('href') ?? '';

            if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:')) {
                return;
            }

            if (url.origin !== window.location.origin) {
                return;
            }

            if (link.hasAttribute('data-no-transition')) {
                return;
            }

            if (url.pathname === window.location.pathname && url.search === window.location.search && url.hash) {
                return;
            }

            if (url.href === window.location.href) {
                return;
            }

            event.preventDefault();
            document.body.classList.remove('page-enter');
            document.body.classList.add('page-leaving');

            window.setTimeout(() => {
                window.location.assign(link.href);
            }, 280);
        },
        { capture: true }
    );
}

function initScrollspy() {
    const links = Array.from(document.querySelectorAll('[data-scrollspy-link]'));

    if (!links.length) {
        return;
    }

    const sections = links
        .map((link) => {
            const href = link.getAttribute('href') ?? '';
            const hash = href.startsWith('#') ? href : `#${href.split('#')[1] ?? ''}`;

            if (!hash || hash === '#') {
                return null;
            }

            const section = document.querySelector(hash);

            return section
                ? {
                      hash,
                      section,
                  }
                : null;
        })
        .filter(Boolean);

    if (!sections.length) {
        return;
    }

    const activate = (hash) => {
        links.forEach((link) => {
            const linkHash = link.getAttribute('href');
            const normalized = linkHash?.startsWith('#') ? linkHash : `#${linkHash?.split('#')[1] ?? ''}`;

            if (normalized === hash) {
                link.classList.add('is-active');
            } else {
                link.classList.remove('is-active');
            }
        });
    };

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    activate(`#${entry.target.id}`);
                }
            });
        },
        {
            threshold: 0.35,
            rootMargin: '-40% 0px -45% 0px',
        }
    );

    sections.forEach(({ section }) => observer.observe(section));

    links.forEach((link) => {
        link.addEventListener('click', () => {
            const hash = link.getAttribute('href');
            if (hash?.startsWith('#')) {
                activate(hash);
            }
        });
    });
}

function initBackToTop() {
    const button = document.querySelector('[data-back-to-top]');

    if (!button) {
        return;
    }

    const syncVisibility = () => {
        const isVisible = window.scrollY > 280;

        button.classList.toggle('is-visible', isVisible);
        button.setAttribute('aria-hidden', String(!isVisible));
    };

    syncVisibility();

    window.addEventListener('scroll', syncVisibility, { passive: true });

    button.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
    });
}

function initActionConfirmations() {
    const confirmableForms = document.querySelectorAll('form[data-confirm]');

    if (!confirmableForms.length) {
        return;
    }

    const modal = document.createElement('div');
    modal.setAttribute('id', 'action-confirm-modal');
    modal.className = 'fixed inset-0 z-[95] hidden items-center justify-center p-4 sm:p-6';
    modal.innerHTML = `
        <div data-confirm-overlay class="absolute inset-0 bg-slate-900/50"></div>
        <div class="relative w-full max-w-md rounded-2xl border border-slate-200 bg-white p-5 shadow-2xl sm:p-6">
            <h2 data-confirm-title class="font-heading text-xl font-bold text-slate-900">Confirm action</h2>
            <p data-confirm-message class="mt-2 text-sm text-slate-600">Are you sure you want to continue?</p>
            <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end sm:gap-3">
                <button type="button" data-confirm-cancel class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="button" data-confirm-submit class="rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-700">Confirm</button>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    const titleElement = modal.querySelector('[data-confirm-title]');
    const messageElement = modal.querySelector('[data-confirm-message]');
    const cancelButton = modal.querySelector('[data-confirm-cancel]');
    const submitButton = modal.querySelector('[data-confirm-submit]');
    const overlay = modal.querySelector('[data-confirm-overlay]');

    /** @type {HTMLFormElement | null} */
    let pendingForm = null;
    /** @type {HTMLElement | null} */
    let lastFocusedElement = null;

    const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
        pendingForm = null;

        if (lastFocusedElement) {
            lastFocusedElement.focus();
            lastFocusedElement = null;
        }
    };

    const openModal = (form) => {
        pendingForm = form;
        lastFocusedElement = document.activeElement instanceof HTMLElement ? document.activeElement : null;

        titleElement.textContent = form.dataset.confirmTitle || 'Confirm action';
        messageElement.textContent = form.dataset.confirmMessage || 'Are you sure you want to continue?';
        submitButton.textContent = form.dataset.confirmButton || 'Confirm';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
        submitButton.focus();
    };

    overlay.addEventListener('click', closeModal);
    cancelButton.addEventListener('click', closeModal);

    submitButton.addEventListener('click', () => {
        if (!pendingForm) {
            closeModal();
            return;
        }

        const formToSubmit = pendingForm;
        closeModal();
        formToSubmit.submit();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && pendingForm) {
            closeModal();
        }
    });

    document.addEventListener(
        'submit',
        (event) => {
            const form = event.target;

            if (!(form instanceof HTMLFormElement)) {
                return;
            }

            if (!form.hasAttribute('data-confirm')) {
                return;
            }

            event.preventDefault();
            openModal(form);
        },
        { capture: true }
    );
}

function initFlashAlerts() {
    const alerts = document.querySelectorAll('[data-flash-alert]');

    if (!alerts.length) {
        return;
    }

    alerts.forEach((alert) => {
        window.setTimeout(() => {
            alert.style.transition = 'opacity 240ms ease, transform 240ms ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-6px)';

            window.setTimeout(() => {
                alert.remove();
            }, 260);
        }, 2000);
    });
}

function initChatMessaging() {
    const form = document.querySelector('[data-chat-form]');
    const messagesContainer = document.querySelector('[data-chat-messages]');

    if (!form || !messagesContainer) {
        return;
    }

    const submitButton = form.querySelector('[data-chat-submit]');
    const bodyInput = form.querySelector('input[name="body"]');
    const attachmentInput = form.querySelector('input[name="attachment"]');
    const attachmentTrigger = form.querySelector('[data-chat-attachment-trigger]');
    const attachmentName = form.querySelector('[data-chat-attachment-name]');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

    const isNearBottom = () => {
        const threshold = 80;
        return messagesContainer.scrollHeight - messagesContainer.scrollTop - messagesContainer.clientHeight < threshold;
    };

    const scrollToBottom = () => {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    };

    const buildOutgoingMessage = (message) => {
        const wrapper = document.createElement('div');
        wrapper.className = 'flex justify-end';

        const bubble = document.createElement('div');
        bubble.className = 'max-w-[80%] rounded-2xl bg-emerald-600 px-3 py-2 text-sm text-white';

        if (message.body_html) {
            const body = document.createElement('p');
            body.className = 'break-words';
            body.innerHTML = message.body_html;
            bubble.appendChild(body);
        }

        if (message.attachment_url) {
            const attachment = document.createElement('a');
            attachment.href = message.attachment_url;
            attachment.target = '_blank';
            attachment.rel = 'noopener';
            attachment.className = 'mt-2 inline-flex rounded-lg border border-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-50 hover:bg-emerald-500';
            attachment.textContent = message.attachment_original_name || 'Attachment';
            bubble.appendChild(attachment);
        }

        const timestamp = document.createElement('p');
        timestamp.className = 'mt-1 text-[10px] text-emerald-100';
        timestamp.textContent = message.created_at_label || '';
        bubble.appendChild(timestamp);

        wrapper.appendChild(bubble);
        return wrapper;
    };

    if (messagesContainer.children.length) {
        scrollToBottom();
    }

    const syncAttachmentLabel = () => {
        if (!attachmentName) {
            return;
        }

        const fileName = attachmentInput?.files?.[0]?.name;
        attachmentName.textContent = fileName || 'No file selected';
    };

    attachmentTrigger?.addEventListener('click', () => {
        attachmentInput?.click();
    });

    attachmentInput?.addEventListener('change', syncAttachmentLabel);
    syncAttachmentLabel();

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const body = (bodyInput?.value ?? '').trim();
        const hasAttachment = !!attachmentInput?.files?.length;

        if (!body && !hasAttachment) {
            showToast('Type a message or attach a file.', 'error');
            return;
        }

        const shouldStickToBottom = isNearBottom();
        const originalButtonText = submitButton?.textContent ?? 'Send';

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Sending...';
        }

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData,
            });

            const payload = await response.json().catch(() => ({}));

            if (!response.ok) {
                const firstError = payload?.errors ? Object.values(payload.errors)[0]?.[0] : null;
                showToast(firstError || payload?.message || 'Message sending failed.', 'error');
                return;
            }

            if (payload?.message) {
                messagesContainer.appendChild(buildOutgoingMessage(payload.message));
            }

            form.reset();
            if (attachmentInput) {
                attachmentInput.value = '';
            }
            syncAttachmentLabel();

            if (shouldStickToBottom) {
                scrollToBottom();
            }

            showToast(payload?.toast || 'Message sent.', 'success');
        } catch (error) {
            showToast('Network error while sending message.', 'error');
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = originalButtonText;
            }
        }
    });
}

function showToast(message, type = 'success') {
    const containerId = 'fh-toast-container';
    let container = document.getElementById(containerId);

    if (!container) {
        container = document.createElement('div');
        container.id = containerId;
        container.className = 'pointer-events-none fixed right-4 top-4 z-[120] flex w-[min(92vw,360px)] flex-col gap-2';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `pointer-events-auto rounded-xl border px-4 py-3 text-sm font-semibold shadow-lg transition ${
        type === 'error'
            ? 'border-rose-200 bg-rose-50 text-rose-700'
            : 'border-emerald-200 bg-emerald-50 text-emerald-700'
    }`;
    toast.textContent = message;
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(-6px)';

    container.appendChild(toast);

    window.requestAnimationFrame(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';
    });

    window.setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(-6px)';
        window.setTimeout(() => {
            toast.remove();
        }, 220);
    }, 2000);
}
