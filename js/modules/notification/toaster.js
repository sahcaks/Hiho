export default class Toaster {
    constructor() {
        this.container = this._getOrCreateContainer();
    }

    /**
     * Отображает уведомление.
     * @param {Object} options - Опции уведомления.
     * @param {string} options.title - Заголовок уведомления.
     * @param {string} options.message - Текст уведомления.
     * @param {string} options.type - Тип уведомления (success, danger, warning, info).
     * @param {number} options.duration - Продолжительность отображения уведомления в миллисекундах.
     */
    showNotification({title, message, type = 'info', duration = 5000}) {
        const toast = document.createElement('div');
        toast.className = `toast text-bg-${type} border-0 show mb-2`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');

        toast.innerHTML = `
            <div class="toast-header">
                <strong class="me-auto">${title}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
            </div>
            <div class="toast-body">${message}</div>
        `;

        this.container.appendChild(toast);

        // Удаляем уведомление через заданное время
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300); // Убираем с анимацией
        }, duration);
    }

    /**
     * Создает контейнер для уведомлений, если его нет.
     * @returns {HTMLElement} Контейнер для уведомлений.
     */
    _getOrCreateContainer() {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container position-fixed top-0 end-0 p-3 d-flex flex-column';
            container.style.zIndex = '1055';
            document.body.appendChild(container);
        }
        return container;
    }
}