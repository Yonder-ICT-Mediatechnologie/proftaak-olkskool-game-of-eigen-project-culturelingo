const cultures = [
  {
    id: 'japanese',
    name: 'Japanese Culture',
    flag: 'IMG/japan.png',
    description: 'Explore tea ceremony, festivals, and etiquette from Japan.',
    lessons: [
      { title: 'Tea ceremony', text: 'The Japanese tea ceremony celebrates harmony, respect, purity, and tranquility.' },
      { title: 'Cherry blossom', text: 'Sakura season is a time for hanami picnics and cultural reflection.' },
      { title: 'Traditional crafts', text: 'Origami, kimono weaving, and pottery are iconic Japanese arts.' }
    ],
    quiz: [
      {
        question: 'What is hanami?',
        choices: ['A tea ritual', 'Cherry blossom viewing', 'New Year festival', 'A martial art'],
        answer: 1
      },
      {
        question: 'Which value is central to the tea ceremony?',
        choices: ['Strength', 'Wealth', 'Harmony', 'Speed'],
        answer: 2
      },
      {
        question: 'Origami is the art of:',
        choices: ['Cooking', 'Paper folding', 'Painting', 'Music'],
        answer: 1
      }
    ]
  },
  {
    id: 'mexican',
    name: 'Mexican Culture',
    flag: 'IMG/mexico.png',
    description: 'Discover Day of Dead, mariachi, street food, and folk art.',
    lessons: [
      { title: 'Day of the Dead', text: 'A joyful celebration honoring ancestors with altars, candles, and marigolds.' },
      { title: 'Street food', text: 'Tacos, elote, and churros are delicious parts of daily Mexican culture.' },
      { title: 'Music', text: 'Mariachi and folk songs are vibrant cultural expressions.' }
    ],
    quiz: [
      {
        question: 'What is Día de los Muertos?',
        choices: ['A harvest festival', 'A celebration of the dead', 'A wedding ritual', 'A sports event'],
        answer: 1
      },
      {
        question: 'Which flower is commonly used in Day of the Dead altars?',
        choices: ['Rose', 'Lily', 'Marigold', 'Sunflower'],
        answer: 2
      },
      {
        question: 'Mariachi music often features which instrument?',
        choices: ['Bagpipes', 'Guitar', 'Violin', 'Flute'],
        answer: 2
      }
    ]
  },
  {
    id: 'egyptian',
    name: 'Egyptian Culture',
    flag: 'IMG/egypt.png',
    description: 'Learn about ancient myths, Nile festivals, and Egyptian craftsmanship.',
    lessons: [
      { title: 'Ancient stories', text: 'Egyptian culture is shaped by legends of gods, pharaohs, and the Nile.' },
      { title: 'Nile life', text: 'The river brings food, celebration, and farming rituals to local communities.' },
      { title: 'Symbolism', text: 'Scarabs, ankhs, and hieroglyphs are powerful cultural symbols.' }
    ],
    quiz: [
      {
        question: 'What ancient river is central to Egyptian culture?',
        choices: ['Amazon', 'Nile', 'Yangtze', 'Mississippi'],
        answer: 1
      },
      {
        question: 'What does an ankh symbolize?',
        choices: ['Strength', 'Beginning', 'Life', 'Wealth'],
        answer: 2
      },
      {
        question: 'Which animal was sacred in ancient Egypt?',
        choices: ['Cat', 'Horse', 'Eagle', 'Wolf'],
        answer: 0
      }
    ]
  },
  {
    id: 'moroccan',
    name: 'Moroccan Culture',
    flag: 'IMG/morocco.png',
    description: 'Experience souks, mint tea rituals, vibrant crafts, and shared meals.',
    lessons: [
      { title: 'Mint tea ritual', text: 'Serving mint tea is a warm sign of hospitality and friendship in Morocco.' },
      { title: 'Souk markets', text: 'Traditional markets are full of spices, carpets, lanterns, and local stories.' },
      { title: 'Moroccan cuisine', text: 'Couscous, tagines, and pastries bring together family flavors and spices.' }
    ],
    quiz: [
      {
        question: 'What is a key ingredient in Moroccan mint tea?',
        choices: ['Basil', 'Rosemary', 'Mint', 'Sage'],
        answer: 2
      },
      {
        question: 'What is a “souk”?',
        choices: ['A spice blend', 'A market', 'A dance', 'A festival'],
        answer: 1
      },
      {
        question: 'Which dish is Moroccan? ',
        choices: ['Sushi', 'Tagine', 'Goulash', 'Paella'],
        answer: 1
      }
    ]
  },
  {
    id: 'turkish',
    name: 'Turkish Culture',
    flag: 'IMG/turkiye.png',
    description: 'Explore bazaars, tea gardens, storytelling, and centuries of Anatolian heritage.',
    lessons: [
      { title: 'Tea gardens', text: 'Turkish tea is a daily ritual shared in tulip-shaped glasses at tea gardens.' },
      { title: 'Bazaars', text: 'Grand Bazaar and spice markets are lively hubs of commerce and conversation.' },
      { title: 'Cultural art', text: 'Iznik tiles, calligraphy, and carpets reflect Turkey’s layered history.' }
    ],
    quiz: [
      {
        question: 'What glass shape is traditional for Turkish tea?',
        choices: ['Square', 'Tulip-shaped', 'Cylinder', 'Bowl'],
        answer: 1
      },
      {
        question: 'What is the Grand Bazaar?',
        choices: ['A palace', 'A market', 'A mosque', 'A festival'],
        answer: 1
      },
      {
        question: 'Which craft is Turkey famous for?',
        choices: ['Origami', 'Iznik tiles', 'Pottery', 'Kilim weaving'],
        answer: 1
      }
    ]
  },
  {
    id: 'chinese',
    name: 'Chinese Culture',
    flag: 'IMG/china.png',
    description: 'Discover festivals, calligraphy, tea culture, and ancient traditions from China.',
    lessons: [
      { title: 'Festivals', text: 'Chinese New Year and Mid-Autumn Festival are full of lanterns, family, and ritual.' },
      { title: 'Tea culture', text: 'Tea has been enjoyed for centuries, from green tea to oolong ceremonies.' },
      { title: 'Symbols', text: 'Dragons, red lanterns, and calligraphy carry deep meanings of luck and harmony.' }
    ],
    quiz: [
      {
        question: 'Which festival uses red lanterns and dragon dances?',
        choices: ['Diwali', 'Chinese New Year', 'Carnival', 'Hanami'],
        answer: 1
      },
      {
        question: 'What drink is central to Chinese culture?',
        choices: ['Coffee', 'Tea', 'Soda', 'Wine'],
        answer: 1
      },
      {
        question: 'What does the dragon often symbolize?',
        choices: ['Luck and power', 'Sadness', 'Silence', 'Speed'],
        answer: 0
      }
    ]
  },
  {
    id: 'indian',
    name: 'Indian Culture',
    flag: 'IMG/india.png',
    description: 'Learn about festivals, spices, dance, and the rich tapestry of Indian life.',
    lessons: [
      { title: 'Festivals', text: 'Diwali, Holi, and many regional festivals bring color, food, and family together.' },
      { title: 'Cuisine', text: 'Spices, street food, and vegetarian dishes are celebrated across India.' },
      { title: 'Performing arts', text: 'Classical dance, Bollywood music, and storytelling are key cultural forms.' }
    ],
    quiz: [
      {
        question: 'Which celebration uses colored powder and joy?',
        choices: ['Diwali', 'Holi', 'Ramadan', 'Carnival'],
        answer: 1
      },
      {
        question: 'What is a common element in Indian cooking?',
        choices: ['Chili spices', 'Tortillas', 'Soy sauce', 'Wasabi'],
        answer: 0
      },
      {
        question: 'Which Indian dance style is classical?',
        choices: ['Tango', 'Kathak', 'Salsa', 'Hip hop'],
        answer: 1
      }
    ]
  },
  {
    id: 'norwegian',
    name: 'Norwegian Culture',
    flag: 'IMG/norway.png',
    description: 'Explore fjords, Viking history, winter traditions, and coastal cuisine of Norway.',
    lessons: [
      { title: 'Fjords', text: 'Norwegian fjords are dramatic landscapes that shape local fishing and outdoor life.' },
      { title: 'Viking heritage', text: 'Viking stories and rune history remain part of Norway’s cultural identity.' },
      { title: 'Hygge and outdoors', text: 'Friluftsliv celebrates outdoor living and cozy time with family in nature.' }
    ],
    quiz: [
      {
        question: 'What is a fjord?',
        choices: ['A traditional hut', 'A narrow coastal inlet', 'A festival', 'A folk dance'],
        answer: 1
      },
      {
        question: 'What is “friluftsliv” about?',
        choices: ['Indoor cooking', 'Outdoor life', 'A winter sport', 'A folk song'],
        answer: 1
      },
      {
        question: 'Which historical group is associated with Norway?',
        choices: ['Samurai', 'Vikings', 'Incas', 'Mongols'],
        answer: 1
      }
    ]
  }
];
