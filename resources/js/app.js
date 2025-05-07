document.addEventListener('DOMContentLoaded', () => {
    // State management
    let state = {
        timer: null,
        timeLeft: 25 * 60,
        sessionId: null,
        isRunning: false,
        isPaused: false,
        duration: 25
    };

    // DOM elements
    const elements = {
        timerDisplay: document.getElementById('timer-display'),
        startBtn: document.getElementById('start-btn'),
        pauseBtn: document.getElementById('pause-btn'),
        stopBtn: document.getElementById('stop-btn'),
        durationBtns: document.querySelectorAll('[data-duration]'),
        customDuration: document.getElementById('custom-duration'),
        taskSelect: document.getElementById('task-select'),
        tree: document.getElementById('tree')
    };

    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    const formatTime = (seconds) => {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    };

    const updateDisplay = () => {
        elements.timerDisplay.textContent = formatTime(state.timeLeft);
        if (elements.tree) {
            const progress = 1 - (state.timeLeft / (state.duration * 60));
            elements.tree.style.transform = `scale(${0.8 + progress * 0.5})`;
        }
    };

    // Timer
    const startTimer = (minutes) => {
        if (state.isRunning) return;
        
        state.duration = minutes;
        state.timeLeft = minutes * 60;
        state.isRunning = true;
        
        elements.durationBtns.forEach(btn => btn.disabled = true);
        elements.customDuration.disabled = true;
        elements.taskSelect.disabled = true;
        elements.startBtn.disabled = true;
        elements.pauseBtn.disabled = false;
        elements.stopBtn.disabled = false;
        
        // Start 
        fetch('/pomodoro/start', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                task_id: elements.taskSelect?.value || null,
                duration: state.duration
            })
        })
        .then(response => response.json())
        .then(data => {
            state.sessionId = data.session_id;
            state.timer = setInterval(() => {
                state.timeLeft--;
                updateDisplay();
                if (state.timeLeft <= 0) completeSession();
            }, 1000);
        })
        .catch(console.error);
    };

    const togglePause = () => {
        if (!state.isRunning) return;
        
        if (state.isPaused) {
            state.timer = setInterval(() => {
                state.timeLeft--;
                updateDisplay();
                if (state.timeLeft <= 0) completeSession();
            }, 1000);
            elements.pauseBtn.textContent = 'Pause';
        } else {
            clearInterval(state.timer);
            elements.pauseBtn.textContent = 'Resume';
        }
        state.isPaused = !state.isPaused;
    };

    const stopTimer = () => {
        clearInterval(state.timer);
        state.isRunning = false;
        fetch(`/pomodoro/${state.sessionId}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        }).catch(console.error);
        resetTimer();
    };

    const completeSession = () => {
        clearInterval(state.timer);
        state.isRunning = false;
        fetch(`/pomodoro/${state.sessionId}/complete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(() => {
            elements.timerDisplay.textContent = 'Done!';
            setTimeout(resetTimer, 2000);
        })
        .catch(console.error);
    };

    const resetTimer = () => {
        clearInterval(state.timer);
        state = {
            ...state,
            timer: null,
            timeLeft: 25 * 60,
            sessionId: null,
            isRunning: false,
            isPaused: false,
            duration: 25
        };
        
        elements.durationBtns.forEach(btn => {
            btn.disabled = false;
            btn.classList.remove('active');
        });
        elements.customDuration.value = '';
        elements.taskSelect.disabled = false;
        elements.startBtn.disabled = false;
        elements.pauseBtn.disabled = true;
        elements.stopBtn.disabled = true;
        elements.pauseBtn.textContent = 'Pause';
        
        document.querySelector('[data-duration="25"]').classList.add('active');
        updateDisplay();
    };

    // Event listeners
    elements.startBtn.addEventListener('click', () => {
        const duration = elements.customDuration.value
            ? parseInt(elements.customDuration.value) || 25
            : document.querySelector('[data-duration].active')
                ? parseInt(document.querySelector('[data-duration].active').dataset.duration)
                : 25;
        startTimer(duration);
    });

    elements.pauseBtn.addEventListener('click', togglePause);
    elements.stopBtn.addEventListener('click', stopTimer);

    elements.durationBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            elements.durationBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            state.duration = parseInt(this.dataset.duration);
            state.timeLeft = state.duration * 60;
            elements.customDuration.value = '';
            updateDisplay();
        });
    });

    elements.customDuration.addEventListener('input', () => {
        if (!elements.customDuration.value) return;
        elements.durationBtns.forEach(btn => btn.classList.remove('active'));
        state.duration = parseInt(elements.customDuration.value) || 25;
        state.timeLeft = state.duration * 60;
        updateDisplay();
    });

    // Initialize
    document.querySelector('[data-duration="25"]').classList.add('active');
    updateDisplay();
});