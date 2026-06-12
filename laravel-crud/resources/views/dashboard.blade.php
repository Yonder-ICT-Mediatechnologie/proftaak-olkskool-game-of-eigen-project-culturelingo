<x-app-layout>

    <header class="site-header">
        <div class="brand">
            <div class="logo">🌍</div>
            <div>
                <h1>CultureLingo</h1>
                <p>Learn cultures through fun micro-lessons.</p>
            </div>
        </div>
        <div class="header-actions">
            <div class="streak">🔥 Streak: <span id="streakValue">0</span> days</div>
            <button id="resetButton" class="btn secondary">Reset</button>
        </div>
    </header>

    <main>
        <section class="hero">
            <div>
                <h2>Trade language learning for cultural discovery.</h2>
                <p>Pick a culture, unlock stories, trivia, and a quick quiz.</p>
            </div>
            <div class="hero-card">
                <div class="hero-card__stat">
                    <strong id="xpValue">0</strong>
                    <span>XP earned</span>
                </div>
                <div class="hero-card__stat">
                    <strong id="culturesCompleted">0</strong>
                    <span>cultures explored</span>
                </div>
            </div>
        </section>

        <section class="culture-grid-section">
            <div class="section-title">
                <h3>Choose a culture</h3>
                <p>Each path includes cultural insights, rituals, festivals, and a quiz.</p>
            </div>
            <div id="cultureGrid" class="culture-grid"></div>
        </section>

        <section id="lessonSection" class="lesson-section hidden">
            <div class="section-title">
                <div>
                    <h3 id="lessonTitle">Culture lesson</h3>
                    <p id="lessonSubtitle">Discover traditions and customs from around the world.</p>
                </div>
                <button id="backButton" class="btn secondary">&#8592; Terug</button>
            </div>
            <div id="lessonCards" class="lesson-cards"></div>
            <div class="action-row">
                <button id="startQuizButton" class="btn primary">Start quiz</button>
            </div>
        </section>

        <section id="quizSection" class="quiz-section hidden">
            <div class="section-title">
                <div>
                    <h3>Quick culture quiz</h3>
                    <p>Answer 5 questions to earn XP for this culture.</p>
                </div>
                <button id="closeQuizButton" class="btn secondary">Quiz sluiten</button>
            </div>
            <div id="quizContainer" class="quiz-container"></div>
        </section>
    </main>

    <footer class="site-footer">
        <p>CultureLingo &middot; Explore traditions, festivals, food and stories.</p>
        <p><a href="{{ route('cultures.index') }}">Cultures beheren (admin)</a></p>
    </footer>

    <script>
    let cultures = [
      {
        id: 'japanese',
        name: 'Japanese Culture',
        emoji: '🎌',
        description: 'Explore tea ceremony, festivals, and etiquette from Japan.',
        lessons: [
          { title: 'Tea ceremony', text: 'The Japanese tea ceremony celebrates harmony, respect, purity, and tranquility.' },
          { title: 'Cherry blossom', text: 'Sakura season is a time for hanami picnics and cultural reflection.' },
          { title: 'Traditional crafts', text: 'Origami, kimono weaving, and pottery are iconic Japanese arts.' }
        ],
        quiz: [
          { question: 'What is hanami?', choices: ['A tea ritual', 'Cherry blossom viewing', 'New Year festival', 'A martial art'], answer: 1 },
          { question: 'Which value is central to the tea ceremony?', choices: ['Strength', 'Wealth', 'Harmony', 'Speed'], answer: 2 },
          { question: 'Origami is the art of:', choices: ['Cooking', 'Paper folding', 'Painting', 'Music'], answer: 1 },
          { question: 'What is a kimono?', choices: ['A type of food', 'A traditional garment', 'A festival', 'A musical instrument'], answer: 1 },
          { question: 'Which season is celebrated with cherry blossoms?', choices: ['Spring', 'Summer', 'Autumn', 'Winter'], answer: 0 }
        ]
      },
      {
        id: 'mexican',
        name: 'Mexican Culture',
        emoji: '🌮',
        description: 'Discover Day of Dead, mariachi, street food, and folk art.',
        lessons: [
          { title: 'Day of the Dead', text: 'A joyful celebration honoring ancestors with altars, candles, and marigolds.' },
          { title: 'Street food', text: 'Tacos, elote, and churros are delicious parts of daily Mexican culture.' },
          { title: 'Music', text: 'Mariachi and folk songs are vibrant cultural expressions.' }
        ],
        quiz: [
          { question: 'What is Día de los Muertos?', choices: ['A harvest festival', 'A celebration of the dead', 'A wedding ritual', 'A sports event'], answer: 1 },
          { question: 'Which flower is used in Day of the Dead altars?', choices: ['Rose', 'Lily', 'Marigold', 'Sunflower'], answer: 2 },
          { question: 'Mariachi music often features which instrument?', choices: ['Bagpipes', 'Guitar', 'Violin', 'Flute'], answer: 2 },
          { question: 'What is "elote"?', choices: ['A type of taco', 'Grilled corn on the cob', 'A spicy sauce', 'A traditional dance'], answer: 1 },
          { question: 'Which of these is a popular Mexican street food?', choices: ['Sushi', 'Churros', 'Pizza', 'Baguette'], answer: 1 }
        ]
      },
      {
        id: 'egyptian',
        name: 'Egyptian Culture',
        emoji: '🏺',
        description: 'Learn about ancient myths, Nile festivals, and Egyptian craftsmanship.',
        lessons: [
          { title: 'Ancient stories', text: 'Egyptian culture is shaped by legends of gods, pharaohs, and the Nile.' },
          { title: 'Nile life', text: 'The river brings food, celebration, and farming rituals to local communities.' },
          { title: 'Symbolism', text: 'Scarabs, ankhs, and hieroglyphs are powerful cultural symbols.' }
        ],
        quiz: [
          { question: 'What ancient river is central to Egyptian culture?', choices: ['Amazon', 'Nile', 'Yangtze', 'Mississippi'], answer: 1 },
          { question: 'What does an ankh symbolize?', choices: ['Strength', 'Beginning', 'Life', 'Wealth'], answer: 2 },
          { question: 'Which animal was sacred in ancient Egypt?', choices: ['Cat', 'Horse', 'Eagle', 'Wolf'], answer: 0 },
          { question: 'What is a scarab?', choices: ['A type of jewelry', 'A beetle symbolizing rebirth', 'A festival', 'A musical instrument'], answer: 1 },
          { question: 'Which of these is an ancient Egyptian god?', choices: ['Zeus', 'Ra', 'Odin', 'Shiva'], answer: 1 }
        ]
      },
      {
        id: 'moroccan',
        name: 'Moroccan Culture',
        emoji: '🕌',
        description: 'Experience souks, mint tea rituals, vibrant crafts, and shared meals.',
        lessons: [
          { title: 'Mint tea ritual', text: 'Serving mint tea is a warm sign of hospitality and friendship in Morocco.' },
          { title: 'Souk markets', text: 'Traditional markets are full of spices, carpets, lanterns, and local stories.' },
          { title: 'Moroccan cuisine', text: 'Couscous, tagines, and pastries bring together family flavors and spices.' }
        ],
        quiz: [
          { question: 'What is a key ingredient in Moroccan mint tea?', choices: ['Basil', 'Rosemary', 'Mint', 'Sage'], answer: 2 },
          { question: 'What is a "souk"?', choices: ['A spice blend', 'A market', 'A dance', 'A festival'], answer: 1 },
          { question: 'Which dish is Moroccan?', choices: ['Sushi', 'Tagine', 'Goulash', 'Paella'], answer: 1 },
          { question: 'What is a common feature of Moroccan crafts?', choices: ['Minimalism', 'Bright colors and intricate patterns', 'Monochrome designs', 'Abstract shapes'], answer: 1 },
          { question: 'Which of these is a traditional Moroccan pastry?', choices: ['Baklava', 'Croissant', 'Macaron', 'Doughnut'], answer: 0 }
        ]
      },
      {
        id: 'turkish',
        name: 'Turkish Culture',
        emoji: '🧿',
        description: 'Explore bazaars, tea gardens, storytelling, and centuries of Anatolian heritage.',
        lessons: [
          { title: 'Tea gardens', text: 'Turkish tea is a daily ritual shared in tulip-shaped glasses at tea gardens.' },
          { title: 'Bazaars', text: 'Grand Bazaar and spice markets are lively hubs of commerce and conversation.' },
          { title: 'Cultural art', text: 'Iznik tiles, calligraphy, and carpets reflect Turkey\'s layered history.' }
        ],
        quiz: [
          { question: 'What glass shape is traditional for Turkish tea?', choices: ['Square', 'Tulip-shaped', 'Cylinder', 'Bowl'], answer: 1 },
          { question: 'What is the Grand Bazaar?', choices: ['A palace', 'A market', 'A mosque', 'A festival'], answer: 1 },
          { question: 'Which craft is Turkey famous for?', choices: ['Origami', 'Iznik tiles', 'Pottery', 'Kilim weaving'], answer: 1 },
          { question: 'What is a common theme in Turkish art?', choices: ['Nature and geometry', 'Abstract expressionism', 'Minimalism', 'Pop culture'], answer: 0 },
          { question: 'Which of these is a traditional Turkish dish?', choices: ['Sushi', 'Kebab', 'Pizza', 'Taco'], answer: 1 }
        ]
      },
      {
        id: 'chinese',
        name: 'Chinese Culture',
        emoji: '🐉',
        description: 'Discover festivals, calligraphy, tea culture, and ancient traditions from China.',
        lessons: [
          { title: 'Festivals', text: 'Chinese New Year and Mid-Autumn Festival are full of lanterns, family, and ritual.' },
          { title: 'Tea culture', text: 'Tea has been enjoyed for centuries, from green tea to oolong ceremonies.' },
          { title: 'Symbols', text: 'Dragons, red lanterns, and calligraphy carry deep meanings of luck and harmony.' }
        ],
        quiz: [
          { question: 'Which festival uses red lanterns and dragon dances?', choices: ['Diwali', 'Chinese New Year', 'Carnival', 'Hanami'], answer: 1 },
          { question: 'What drink is central to Chinese culture?', choices: ['Coffee', 'Tea', 'Soda', 'Wine'], answer: 1 },
          { question: 'What does the dragon often symbolize?', choices: ['Luck and power', 'Sadness', 'Silence', 'Speed'], answer: 0 },
          { question: 'Which of these is a traditional Chinese art form?', choices: ['Calligraphy', 'Origami', 'Mosaic', 'Graffiti'], answer: 0 },
          { question: 'What is a common theme in Chinese festivals?', choices: ['Family and renewal', 'Individual achievement', 'Sports and competition', 'Technology'], answer: 0 }
        ]
      },
      {
        id: 'indian',
        name: 'Indian Culture',
        emoji: '🪔',
        description: 'Learn about festivals, spices, dance, and the rich tapestry of Indian life.',
        lessons: [
          { title: 'Festivals', text: 'Diwali, Holi, and many regional festivals bring color, food, and family together.' },
          { title: 'Cuisine', text: 'Spices, street food, and vegetarian dishes are celebrated across India.' },
          { title: 'Performing arts', text: 'Classical dance, Bollywood music, and storytelling are key cultural forms.' }
        ],
        quiz: [
          { question: 'Which celebration uses colored powder and joy?', choices: ['Diwali', 'Holi', 'Ramadan', 'Carnival'], answer: 1 },
          { question: 'What is a common element in Indian cooking?', choices: ['Chili spices', 'Tortillas', 'Soy sauce', 'Wasabi'], answer: 0 },
          { question: 'Which Indian dance style is classical?', choices: ['Tango', 'Kathak', 'Salsa', 'Hip hop'], answer: 1 },
          { question: 'What is a common theme in Indian festivals?', choices: ['Family and spirituality', 'Individual achievement', 'Sports', 'Technology'], answer: 0 },
          { question: 'Which of these is a popular Indian street food?', choices: ['Samosa', 'Pizza', 'Taco', 'Baguette'], answer: 0 }
        ]
      },
      {
        id: 'norwegian',
        name: 'Norwegian Culture',
        emoji: '❄️',
        description: 'Explore fjords, Viking history, winter traditions, and coastal cuisine of Norway.',
        lessons: [
          { title: 'Fjords', text: 'Norwegian fjords are dramatic landscapes that shape local fishing and outdoor life.' },
          { title: 'Viking heritage', text: 'Viking stories and rune history remain part of Norway\'s cultural identity.' },
          { title: 'Hygge and outdoors', text: 'Friluftsliv celebrates outdoor living and cozy time with family in nature.' }
        ],
        quiz: [
          { question: 'What is a fjord?', choices: ['A traditional hut', 'A narrow coastal inlet', 'A festival', 'A folk dance'], answer: 1 },
          { question: 'What is "friluftsliv" about?', choices: ['Indoor cooking', 'Outdoor life', 'A winter sport', 'A folk song'], answer: 1 },
          { question: 'Which historical group is associated with Norway?', choices: ['Samurai', 'Vikings', 'Incas', 'Mongols'], answer: 1 },
          { question: 'What is a common theme in Norwegian culture?', choices: ['Family and nature', 'Individual achievement', 'Sports', 'Technology'], answer: 0 },
          { question: 'Which of these is a traditional Norwegian dish?', choices: ['Sushi', 'Lutefisk', 'Pizza', 'Taco'], answer: 1 }
        ]
      }
    ];

    const state = {
      selectedCulture: null,
      currentQuiz: null,
      currentQuestion: 0,
      score: 0,
      xp: 0,
      culturesCompleted: 0,
      streak: 0
    };

    const cultureGrid      = document.getElementById('cultureGrid');
    const lessonSection    = document.getElementById('lessonSection');
    const quizSection      = document.getElementById('quizSection');
    const lessonTitle      = document.getElementById('lessonTitle');
    const lessonSubtitle   = document.getElementById('lessonSubtitle');
    const lessonCards      = document.getElementById('lessonCards');
    const quizContainer    = document.getElementById('quizContainer');
    const streakValue      = document.getElementById('streakValue');
    const xpValue          = document.getElementById('xpValue');
    const culturesCompleted = document.getElementById('culturesCompleted');
    const resetButton      = document.getElementById('resetButton');
    const startQuizButton  = document.getElementById('startQuizButton');
    const backButton       = document.getElementById('backButton');
    const closeQuizButton  = document.getElementById('closeQuizButton');

    function renderCultureCards() {
      cultureGrid.innerHTML = cultures.map(culture => `
        <article class="culture-card" data-id="${culture.id}">
          <div class="pill">${culture.emoji} ${culture.name}</div>
          <h4>${culture.name}</h4>
          <p>${culture.description}</p>
        </article>
      `).join('');

      cultureGrid.querySelectorAll('.culture-card').forEach(card => {
        card.addEventListener('click', () => selectCulture(card.dataset.id));
      });
    }

    function selectCulture(id) {
      state.selectedCulture = cultures.find(c => c.id === id);
      state.currentQuestion = 0;
      state.score = 0;
      lessonTitle.textContent = `${state.selectedCulture.name} journey`;
      lessonSubtitle.textContent = `Explore ${state.selectedCulture.name.toLowerCase()} with quick cultural lessons and trivia.`;
      renderLessonCards();
      lessonSection.classList.remove('hidden');
      quizSection.classList.add('hidden');
      window.scrollTo({ top: lessonSection.offsetTop - 20, behavior: 'smooth' });
    }

    function renderLessonCards() {
      lessonCards.innerHTML = state.selectedCulture.lessons.map(lesson => `
        <article class="lesson-card">
          <h4>${lesson.title}</h4>
          <p>${lesson.text}</p>
        </article>
      `).join('');
    }

    function startQuiz() {
      if (!state.selectedCulture) return;
      state.currentQuiz = state.selectedCulture.quiz;
      state.currentQuestion = 0;
      state.score = 0;
      renderQuizQuestion();
      quizSection.classList.remove('hidden');
      window.scrollTo({ top: quizSection.offsetTop - 20, behavior: 'smooth' });
    }

    function renderQuizQuestion() {
      const q = state.currentQuiz[state.currentQuestion];
      quizContainer.innerHTML = `
        <article class="quiz-card">
          <h4>Vraag ${state.currentQuestion + 1} van ${state.currentQuiz.length}</h4>
          <p>${q.question}</p>
          <div class="options">
            ${q.choices.map((choice, i) => `
              <button class="option" data-index="${i}">${choice}</button>
            `).join('')}
          </div>
        </article>
      `;
      quizContainer.querySelectorAll('.option').forEach(btn => {
        btn.addEventListener('click', () => checkAnswer(Number(btn.dataset.index), btn));
      });
    }

    function checkAnswer(selectedIndex, optionElement) {
      const q = state.currentQuiz[state.currentQuestion];
      const isCorrect = selectedIndex === q.answer;
      optionElement.classList.add(isCorrect ? 'correct' : 'wrong');
      if (isCorrect) state.score += 1;

      quizContainer.querySelectorAll('.option').forEach(btn => {
        btn.disabled = true;
        if (Number(btn.dataset.index) === q.answer) btn.classList.add('correct');
      });

      setTimeout(() => {
        state.currentQuestion += 1;
        if (state.currentQuestion < state.currentQuiz.length) {
          renderQuizQuestion();
        } else {
          completeQuiz();
        }
      }, 800);
    }

    function completeQuiz() {
      const earned = state.score * 25;
      state.xp += earned;
      state.culturesCompleted += 1;
      state.streak += 1;
      xpValue.textContent = state.xp;
      culturesCompleted.textContent = state.culturesCompleted;
      streakValue.textContent = state.streak;

      quizContainer.innerHTML = `
        <article class="quiz-card">
          <h4>Quiz voltooid! 🎉</h4>
          <p>Je scoorde ${state.score} van de ${state.currentQuiz.length} vragen.</p>
          <p>+${earned} XP verdiend voor ${state.selectedCulture.name}!</p>
        </article>
      `;
    }

    function resetProgress() {
      state.xp = 0;
      state.culturesCompleted = 0;
      state.streak = 0;
      xpValue.textContent = 0;
      culturesCompleted.textContent = 0;
      streakValue.textContent = 0;
    }

    resetButton.addEventListener('click', resetProgress);
    startQuizButton.addEventListener('click', startQuiz);
    backButton.addEventListener('click', () => {
      lessonSection.classList.add('hidden');
      quizSection.classList.add('hidden');
    });
    closeQuizButton.addEventListener('click', () => {
      quizSection.classList.add('hidden');
    });

    async function loadCultureData() {
      try {
        const res = await fetch('/api/cultures');
        if (!res.ok) throw new Error('API niet beschikbaar');
        const data = await res.json();
        if (Array.isArray(data) && data.length > 0) cultures = data;
      } catch (e) {
        // geen API? gebruik de hardcoded cultures hierboven
      }
    }

    loadCultureData().then(renderCultureCards).catch(renderCultureCards);
    </script>

</x-app-layout>