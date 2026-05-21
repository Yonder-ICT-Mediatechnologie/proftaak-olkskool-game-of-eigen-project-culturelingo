// Culture data loaded from JS/data.js

const state = {
  selectedCulture: null,
  currentQuiz: null,
  currentQuestion: 0,
  score: 0,
  xp: 320,
  culturesCompleted: 3,
  streak: 5
};

const cultureGrid = document.getElementById('cultureGrid');
const lessonSection = document.getElementById('lessonSection');
const lessonTitle = document.getElementById('lessonTitle');
const lessonSubtitle = document.getElementById('lessonSubtitle');
const lessonCards = document.getElementById('lessonCards');
const quizSection = document.getElementById('quizSection');
const quizContainer = document.getElementById('quizContainer');
const quizIntro = document.getElementById('quizIntro');
const closeQuizButton = document.getElementById('closeQuizButton');
const streakValue = document.getElementById('streakValue');
const xpValue = document.getElementById('xpValue');
const culturesCompleted = document.getElementById('culturesCompleted');
const resetButton = document.getElementById('resetButton');
const startQuizButton = document.getElementById('startQuizButton');
const backButton = document.getElementById('backButton');

function renderCultureCards() {
  cultureGrid.innerHTML = cultures
    .map(culture => `
      <article class="culture-card" data-id="${culture.id}" style="background-image: linear-gradient(180deg, rgba(15,23,42,0.35), rgba(15,23,42,0.75)), url('${culture.flag}')">
        <div class="pill">${culture.emoji} ${culture.name}</div>
        <h4>${culture.name}</h4>
        <p>${culture.description}</p>
      </article>
    `)
    .join('');

  cultureGrid.querySelectorAll('.culture-card').forEach(card => {
    card.addEventListener('click', () => selectCulture(card.dataset.id));
  });
}

cultureGrid.addEventListener('wheel', event => {
  if (Math.abs(event.deltaY) > Math.abs(event.deltaX)) {
    event.preventDefault();
    cultureGrid.scrollLeft += event.deltaY;
  }
});

function selectCulture(id) {
  state.selectedCulture = cultures.find(culture => culture.id === id);
  lessonTitle.textContent = `${state.selectedCulture.name} journey`;
  lessonSubtitle.textContent = `Explore ${state.selectedCulture.name.toLowerCase()} with quick cultural lessons and trivia.`;
  renderLessonCards();
  lessonSection.classList.remove('hidden');
  quizSection.classList.add('hidden');
  window.scrollTo({ top: lessonSection.offsetTop - 20, behavior: 'smooth' });
}

function renderLessonCards() {
  lessonCards.innerHTML = state.selectedCulture.lessons
    .map(lesson => `
      <article class="lesson-card">
        <h4>${lesson.title}</h4>
        <p>${lesson.text}</p>
      </article>
    `)
    .join('');
}

function startQuiz() {
  if (!state.selectedCulture) return;
  state.currentQuiz = state.selectedCulture.quiz;
  state.currentQuestion = 0;
  state.score = 0;
  quizIntro.textContent = `Answer 3 questions about ${state.selectedCulture.name}.`;
  renderQuizQuestion();
  lessonSection.classList.add('hidden');
  quizSection.classList.remove('hidden');
  window.scrollTo({ top: quizSection.offsetTop - 20, behavior: 'smooth' });
}

function renderQuizQuestion() {
  const questionData = state.currentQuiz[state.currentQuestion];
  quizContainer.innerHTML = `
    <article class="quiz-card">
      <h4>Question ${state.currentQuestion + 1}</h4>
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
  const questionData = state.currentQuiz[state.currentQuestion];
  const isCorrect = selectedIndex === questionData.answer;

  optionElement.classList.add(isCorrect ? 'correct' : 'wrong');
  if (isCorrect) state.score += 1;

  quizContainer.querySelectorAll('.option').forEach(button => {
    button.disabled = true;
    const index = Number(button.dataset.index);
    if (index === questionData.answer) button.classList.add('correct');
  });

  setTimeout(() => {
    state.currentQuestion += 1;
    if (state.currentQuestion < state.currentQuiz.length) {
      renderQuizQuestion();
    } else {
      completeQuiz();
    }
  }, 700);
}

function completeQuiz() {
  const earnedXp = state.score * 25;
  state.xp += earnedXp;
  state.culturesCompleted += 1;
  state.streak += 1;
  saveProgress();
  xpValue.textContent = state.xp;
  culturesCompleted.textContent = state.culturesCompleted;
  streakValue.textContent = state.streak;

  quizContainer.innerHTML = `
    <article class="quiz-card">
      <h4>Quiz complete!</h4>
      <p>You scored ${state.score} out of ${state.currentQuiz.length}.</p>
      <p>Earned ${earnedXp} XP for exploring ${state.selectedCulture.name}.</p>
    </article>
  `;
}

function loadProgress() {
  const saved = JSON.parse(localStorage.getItem('cultureLingoProgress') || 'null');
  if (saved) {
    state.xp = saved.xp ?? state.xp;
    state.culturesCompleted = saved.culturesCompleted ?? state.culturesCompleted;
    state.streak = saved.streak ?? state.streak;
  }
  xpValue.textContent = state.xp;
  culturesCompleted.textContent = state.culturesCompleted;
  streakValue.textContent = state.streak;
}

function saveProgress() {
  localStorage.setItem('cultureLingoProgress', JSON.stringify({
    xp: state.xp,
    culturesCompleted: state.culturesCompleted,
    streak: state.streak
  }));
}

function resetProgress() {
  state.xp = 0;
  state.culturesCompleted = 0;
  state.streak = 0;
  xpValue.textContent = state.xp;
  culturesCompleted.textContent = state.culturesCompleted;
  streakValue.textContent = state.streak;
  localStorage.removeItem('cultureLingoProgress');
}

resetButton.addEventListener('click', resetProgress);
startQuizButton.addEventListener('click', startQuiz);
backButton.addEventListener('click', () => {
  lessonSection.classList.add('hidden');
});

loadProgress();
renderCultureCards();