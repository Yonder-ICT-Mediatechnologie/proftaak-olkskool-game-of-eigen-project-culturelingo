const quizContainer = document.getElementById('quizContainer');
const quizSubtitle = document.getElementById('quizSubtitle');
const urlParams = new URLSearchParams(window.location.search);
const cultureId = urlParams.get('culture');
const selectedCulture = cultures.find(culture => culture.id === cultureId);

const quizState = {
  currentQuestion: 0,
  score: 0,
  currentQuiz: selectedCulture ? selectedCulture.quiz : []
};

function loadProgress() {
  const saved = JSON.parse(localStorage.getItem('cultureLingoProgress') || 'null');
  return {
    xp: saved?.xp ?? 0,
    culturesCompleted: saved?.culturesCompleted ?? 0,
    streak: saved?.streak ?? 0
  };
}

function saveProgress(progress) {
  localStorage.setItem('cultureLingoProgress', JSON.stringify(progress));
}

function showMessage(message) {
  quizContainer.innerHTML = `
    <article class="quiz-card">
      <h4>${message}</h4>
      <p><a href="index.html" class="btn primary">Return home</a></p>
    </article>
  `;
}

function renderQuizQuestion() {
  const questionData = quizState.currentQuiz[quizState.currentQuestion];
  quizContainer.innerHTML = `
    <article class="quiz-card">
      <h4>Question ${quizState.currentQuestion + 1}</h4>
      <p>${questionData.question}</p>
      <div class="options">
        ${questionData.choices
          .map(
            (choice, index) => `
            <button class="option" data-index="${index}">${choice}</button>
          `
          )
          .join('')}
      </div>
    </article>
  `;

  quizContainer.querySelectorAll('.option').forEach(option => {
    option.addEventListener('click', () => checkAnswer(Number(option.dataset.index), option));
  });
}

function checkAnswer(selectedIndex, optionElement) {
  const questionData = quizState.currentQuiz[quizState.currentQuestion];
  const isCorrect = selectedIndex === questionData.answer;

  optionElement.classList.add(isCorrect ? 'correct' : 'wrong');
  if (isCorrect) quizState.score += 1;

  quizContainer.querySelectorAll('.option').forEach(button => {
    button.disabled = true;
    const index = Number(button.dataset.index);
    if (index === questionData.answer) button.classList.add('correct');
  });

  setTimeout(() => {
    quizState.currentQuestion += 1;
    if (quizState.currentQuestion < quizState.currentQuiz.length) {
      renderQuizQuestion();
    } else {
      completeQuiz();
    }
  }, 700);
}

function completeQuiz() {
  const earnedXp = quizState.score * 25;
  const progress = loadProgress();
  progress.xp += earnedXp;
  progress.culturesCompleted += 1;
  progress.streak += 1;
  saveProgress(progress);

  quizContainer.innerHTML = `
    <article class="quiz-card">
      <h4>Quiz complete!</h4>
      <p>You scored ${quizState.score} out of ${quizState.currentQuiz.length}.</p>
      <p>Earned ${earnedXp} XP for exploring ${selectedCulture.name}.</p>
      <p><a href="index.html" class="btn primary">Return home</a></p>
    </article>
  `;
}

function initQuizPage() {
  if (!selectedCulture) {
    quizSubtitle.textContent = 'No culture selected. Please return to the main page and choose one.';
    showMessage('No valid culture found.');
    return;
  }

  quizSubtitle.textContent = `Answer 3 questions about ${selectedCulture.name}.`;
  renderQuizQuestion();
}

initQuizPage();
