let currentIndex = 0;
const results = [];

const progressEl = document.getElementById('progress');
const wordDisplay = document.getElementById('word-display');
const optionButtons = document.querySelectorAll('.option-button');
const nextButton = document.getElementById('next');
const finishForm = document.getElementById('finish-form');
const resultsInput = document.getElementById('results-input');

function renderQuestion() {
    const current = gameWords[currentIndex];

    wordDisplay.textContent = current.word;

    const options = [current.correct, ...current.incorrect];
    const shuffled = shuffleArray(options);

    optionButtons.forEach((btn, i) => {
        const option = shuffled[i];
        btn.textContent = option.word;
        btn.disabled = false;
        btn.classList.remove('correct', 'wrong');

        btn.onclick = () => {
            const isCorrect = option.id === current.correct.id;
            results.push({ word_id: current.id, correct: isCorrect });

            if (isCorrect) {
                btn.classList.add('correct');
            } else {
                btn.classList.add('wrong');
                optionButtons.forEach(optBtn => {
                    const optText = optBtn.textContent;
                    if (optText === current.correct.word) {
                        optBtn.classList.add('correct');
                    }
                });
            }

            optionButtons.forEach(b => b.disabled = true);
            nextButton.disabled = false;

            if (currentIndex === gameWords.length - 1) {
                nextButton.style.display = 'none';
                finishForm.style.display = 'block';
                resultsInput.value = JSON.stringify(results);
            }
        };
    });

    progressEl.textContent = `${currentIndex + 1} / ${gameWords.length}`;
    nextButton.disabled = true;
}

nextButton.addEventListener('click', () => {
    currentIndex++;
    if (currentIndex < gameWords.length) {
        renderQuestion();
    }
});

function shuffleArray(arr) {
    const a = arr.slice();
    for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [a[i], a[j]] = [a[j], a[i]];
    }
    return a;
}

renderQuestion();