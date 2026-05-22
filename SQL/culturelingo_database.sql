-- ============================================================
--  CultureLingo — MySQL Database Schema
-- ============================================================

CREATE DATABASE IF NOT EXISTS culturelingo
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE culturelingo;

-- ------------------------------------------------------------
-- 1. CULTURES
-- ------------------------------------------------------------
CREATE TABLE cultures (
  id          VARCHAR(50)   PRIMARY KEY,
  name        VARCHAR(100)  NOT NULL,
  emoji       VARCHAR(10)   NOT NULL,
  flag_path   VARCHAR(255)  NOT NULL,
  description TEXT          NOT NULL,
  created_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
);

-- ------------------------------------------------------------
-- 2. LESSONS  (each culture has multiple lessons)
-- ------------------------------------------------------------
CREATE TABLE lessons (
  id           INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  culture_id   VARCHAR(50)   NOT NULL,
  sort_order   TINYINT       NOT NULL DEFAULT 0,
  title        VARCHAR(150)  NOT NULL,
  body         TEXT          NOT NULL,
  created_at   TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT fk_lessons_culture
    FOREIGN KEY (culture_id) REFERENCES cultures(id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

-- ------------------------------------------------------------
-- 3. QUIZ QUESTIONS
-- ------------------------------------------------------------
CREATE TABLE quiz_questions (
  id           INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  culture_id   VARCHAR(50)   NOT NULL,
  sort_order   TINYINT       NOT NULL DEFAULT 0,
  question     TEXT          NOT NULL,
  created_at   TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT fk_questions_culture
    FOREIGN KEY (culture_id) REFERENCES cultures(id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

-- ------------------------------------------------------------
-- 4. QUIZ CHOICES  (one row per answer option)
-- ------------------------------------------------------------
CREATE TABLE quiz_choices (
  id           INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  question_id  INT UNSIGNED  NOT NULL,
  choice_order TINYINT       NOT NULL,          -- 0-based index
  choice_text  VARCHAR(255)  NOT NULL,
  is_correct   TINYINT(1)    NOT NULL DEFAULT 0,

  CONSTRAINT fk_choices_question
    FOREIGN KEY (question_id) REFERENCES quiz_questions(id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

-- ------------------------------------------------------------
-- 5. USERS
-- ------------------------------------------------------------
CREATE TABLE users (
  id           INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  username     VARCHAR(80)   NOT NULL UNIQUE,
  email        VARCHAR(180)  NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at   TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
);

-- ------------------------------------------------------------
-- 6. USER PROGRESS  (one row per user, updated in place)
-- ------------------------------------------------------------
CREATE TABLE user_progress (
  user_id             INT UNSIGNED  PRIMARY KEY,
  xp                  INT UNSIGNED  NOT NULL DEFAULT 0,
  cultures_completed  INT UNSIGNED  NOT NULL DEFAULT 0,
  streak_days         INT UNSIGNED  NOT NULL DEFAULT 0,
  last_activity_date  DATE,
  updated_at          TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
                                    ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT fk_progress_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

-- ------------------------------------------------------------
-- 7. QUIZ ATTEMPTS  (one row per completed quiz)
-- ------------------------------------------------------------
CREATE TABLE quiz_attempts (
  id           INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  user_id      INT UNSIGNED  NOT NULL,
  culture_id   VARCHAR(50)   NOT NULL,
  score        TINYINT       NOT NULL,           -- correct answers
  total        TINYINT       NOT NULL,           -- total questions
  xp_earned    SMALLINT      NOT NULL DEFAULT 0,
  attempted_at TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT fk_attempts_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_attempts_culture
    FOREIGN KEY (culture_id) REFERENCES cultures(id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

-- ------------------------------------------------------------
-- 8. QUIZ ATTEMPT ANSWERS  (per-question breakdown)
-- ------------------------------------------------------------
CREATE TABLE quiz_attempt_answers (
  id              INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
  attempt_id      INT UNSIGNED  NOT NULL,
  question_id     INT UNSIGNED  NOT NULL,
  chosen_choice_id INT UNSIGNED NOT NULL,
  is_correct      TINYINT(1)    NOT NULL,

  CONSTRAINT fk_answers_attempt
    FOREIGN KEY (attempt_id) REFERENCES quiz_attempts(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_answers_question
    FOREIGN KEY (question_id) REFERENCES quiz_questions(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_answers_choice
    FOREIGN KEY (chosen_choice_id) REFERENCES quiz_choices(id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

-- ============================================================
--  SEED DATA — Cultures
-- ============================================================
INSERT INTO cultures (id, name, emoji, flag_path, description) VALUES
  ('japanese', 'Japanese Culture', '🎌', 'IMG/japan.png',    'Explore tea ceremony, festivals, and etiquette from Japan.'),
  ('mexican',  'Mexican Culture',  '🌮', 'IMG/mexico.png',   'Discover Day of Dead, mariachi, street food, and folk art.'),
  ('egyptian', 'Egyptian Culture', '🕌', 'IMG/egypt.png',    'Learn about ancient myths, Nile festivals, and Egyptian craftsmanship.'),
  ('moroccan', 'Moroccan Culture', '🕌', 'IMG/morocco.png',  'Experience souks, mint tea rituals, vibrant crafts, and shared meals.'),
  ('turkish',  'Turkish Culture',  '🧿', 'IMG/turkiye.png',  'Explore bazaars, tea gardens, storytelling, and centuries of Anatolian heritage.'),
  ('chinese',  'Chinese Culture',  '🐉', 'IMG/china.png',    'Discover festivals, calligraphy, tea culture, and ancient traditions from China.'),
  ('indian',   'Indian Culture',   '🪔', 'IMG/india.png',    'Learn about festivals, spices, dance, and the rich tapestry of Indian life.'),
  ('norwegian','Norwegian Culture','❄️', 'IMG/norway.png',   'Explore fjords, Viking history, winter traditions, and coastal cuisine of Norway.');

-- ============================================================
--  SEED DATA — Lessons
-- ============================================================
INSERT INTO lessons (culture_id, sort_order, title, body) VALUES
  -- Japanese
  ('japanese', 0, 'Tea ceremony',     'The Japanese tea ceremony celebrates harmony, respect, purity, and tranquility.'),
  ('japanese', 1, 'Cherry blossom',   'Sakura season is a time for hanami picnics and cultural reflection.'),
  ('japanese', 2, 'Traditional crafts','Origami, kimono weaving, and pottery are iconic Japanese arts.'),
  -- Mexican
  ('mexican',  0, 'Day of the Dead',  'A joyful celebration honoring ancestors with altars, candles, and marigolds.'),
  ('mexican',  1, 'Street food',      'Tacos, elote, and churros are delicious parts of daily Mexican culture.'),
  ('mexican',  2, 'Music',            'Mariachi and folk songs are vibrant cultural expressions.'),
  -- Egyptian
  ('egyptian', 0, 'Ancient stories',  'Egyptian culture is shaped by legends of gods, pharaohs, and the Nile.'),
  ('egyptian', 1, 'Nile life',        'The river brings food, celebration, and farming rituals to local communities.'),
  ('egyptian', 2, 'Symbolism',        'Scarabs, ankhs, and hieroglyphs are powerful cultural symbols.'),
  -- Moroccan
  ('moroccan', 0, 'Mint tea ritual',  'Serving mint tea is a warm sign of hospitality and friendship in Morocco.'),
  ('moroccan', 1, 'Souk markets',     'Traditional markets are full of spices, carpets, lanterns, and local stories.'),
  ('moroccan', 2, 'Moroccan cuisine', 'Couscous, tagines, and pastries bring together family flavors and spices.'),
  -- Turkish
  ('turkish',  0, 'Tea gardens',      'Turkish tea is a daily ritual shared in tulip-shaped glasses at tea gardens.'),
  ('turkish',  1, 'Bazaars',          'Grand Bazaar and spice markets are lively hubs of commerce and conversation.'),
  ('turkish',  2, 'Cultural art',     'Iznik tiles, calligraphy, and carpets reflect Turkey''s layered history.'),
  -- Chinese
  ('chinese',  0, 'Festivals',        'Chinese New Year and Mid-Autumn Festival are full of lanterns, family, and ritual.'),
  ('chinese',  1, 'Tea culture',      'Tea has been enjoyed for centuries, from green tea to oolong ceremonies.'),
  ('chinese',  2, 'Symbols',          'Dragons, red lanterns, and calligraphy carry deep meanings of luck and harmony.'),
  -- Indian
  ('indian',   0, 'Festivals',        'Diwali, Holi, and many regional festivals bring color, food, and family together.'),
  ('indian',   1, 'Cuisine',          'Spices, street food, and vegetarian dishes are celebrated across India.'),
  ('indian',   2, 'Performing arts',  'Classical dance, Bollywood music, and storytelling are key cultural forms.'),
  -- Norwegian
  ('norwegian',0, 'Fjords',           'Norwegian fjords are dramatic landscapes that shape local fishing and outdoor life.'),
  ('norwegian',1, 'Viking heritage',  'Viking stories and rune history remain part of Norway''s cultural identity.'),
  ('norwegian',2, 'Hygge and outdoors','Friluftsliv celebrates outdoor living and cozy time with family in nature.');

-- ============================================================
--  SEED DATA — Quiz Questions & Choices
-- ============================================================

-- ---- Japanese ----
INSERT INTO quiz_questions (culture_id, sort_order, question) VALUES
  ('japanese', 0, 'What is hanami?'),
  ('japanese', 1, 'Which value is central to the tea ceremony?'),
  ('japanese', 2, 'Origami is the art of:'),
  ('japanese', 3, 'What is a kimono?'),
  ('japanese', 4, 'Which season is celebrated with cherry blossoms?');

INSERT INTO quiz_choices (question_id, choice_order, choice_text, is_correct) VALUES
  -- Q1
  (1, 0, 'A tea ritual',           0),
  (1, 1, 'Cherry blossom viewing', 1),
  (1, 2, 'New Year festival',      0),
  (1, 3, 'A martial art',          0),
  -- Q2
  (2, 0, 'Strength',  0),
  (2, 1, 'Wealth',    0),
  (2, 2, 'Harmony',   1),
  (2, 3, 'Speed',     0),
  -- Q3
  (3, 0, 'Cooking',       0),
  (3, 1, 'Paper folding', 1),
  (3, 2, 'Painting',      0),
  (3, 3, 'Music',         0),
  -- Q4
  (4, 0, 'A type of food',       0),
  (4, 1, 'A traditional garment',1),
  (4, 2, 'A festival',           0),
  (4, 3, 'A musical instrument', 0),
  -- Q5
  (5, 0, 'Spring', 1),
  (5, 1, 'Summer', 0),
  (5, 2, 'Autumn', 0),
  (5, 3, 'Winter', 0);

-- ---- Mexican ----
INSERT INTO quiz_questions (culture_id, sort_order, question) VALUES
  ('mexican', 0, 'What is Día de los Muertos?'),
  ('mexican', 1, 'Which flower is commonly used in Day of the Dead altars?'),
  ('mexican', 2, 'Mariachi music often features which instrument?'),
  ('mexican', 3, 'What is "elote"?'),
  ('mexican', 4, 'Which of these is a popular Mexican street food?');

INSERT INTO quiz_choices (question_id, choice_order, choice_text, is_correct) VALUES
  (6, 0, 'A harvest festival',        0),
  (6, 1, 'A celebration of the dead', 1),
  (6, 2, 'A wedding ritual',          0),
  (6, 3, 'A sports event',            0),

  (7, 0, 'Rose',      0),
  (7, 1, 'Lily',      0),
  (7, 2, 'Marigold',  1),
  (7, 3, 'Sunflower', 0),

  (8, 0, 'Bagpipes', 0),
  (8, 1, 'Guitar',   0),
  (8, 2, 'Violin',   1),
  (8, 3, 'Flute',    0),

  (9, 0, 'A type of taco',           0),
  (9, 1, 'Grilled corn on the cob',  1),
  (9, 2, 'A spicy sauce',            0),
  (9, 3, 'A traditional dance',      0),

  (10, 0, 'Sushi',   0),
  (10, 1, 'Churros', 1),
  (10, 2, 'Pizza',   0),
  (10, 3, 'Baguette',0);

-- ---- Egyptian ----
INSERT INTO quiz_questions (culture_id, sort_order, question) VALUES
  ('egyptian', 0, 'What ancient river is central to Egyptian culture?'),
  ('egyptian', 1, 'What does an ankh symbolize?'),
  ('egyptian', 2, 'Which animal was sacred in ancient Egypt?'),
  ('egyptian', 3, 'What is a scarab?'),
  ('egyptian', 4, 'Which of these is an ancient Egyptian god?');

INSERT INTO quiz_choices (question_id, choice_order, choice_text, is_correct) VALUES
  (11, 0, 'Amazon',      0),
  (11, 1, 'Nile',        1),
  (11, 2, 'Yangtze',     0),
  (11, 3, 'Mississippi', 0),

  (12, 0, 'Strength',   0),
  (12, 1, 'Beginning',  0),
  (12, 2, 'Life',       1),
  (12, 3, 'Wealth',     0),

  (13, 0, 'Cat',   1),
  (13, 1, 'Horse', 0),
  (13, 2, 'Eagle', 0),
  (13, 3, 'Wolf',  0),

  (14, 0, 'A type of jewelry',          0),
  (14, 1, 'A beetle symbolizing rebirth',1),
  (14, 2, 'A festival',                 0),
  (14, 3, 'A musical instrument',       0),

  (15, 0, 'Zeus',  0),
  (15, 1, 'Ra',    1),
  (15, 2, 'Odin',  0),
  (15, 3, 'Shiva', 0);

-- ---- Moroccan ----
INSERT INTO quiz_questions (culture_id, sort_order, question) VALUES
  ('moroccan', 0, 'What is a key ingredient in Moroccan mint tea?'),
  ('moroccan', 1, 'What is a "souk"?'),
  ('moroccan', 2, 'Which dish is Moroccan?'),
  ('moroccan', 3, 'What is a common feature of Moroccan crafts?'),
  ('moroccan', 4, 'Which of these is a traditional Moroccan pastry?');

INSERT INTO quiz_choices (question_id, choice_order, choice_text, is_correct) VALUES
  (16, 0, 'Basil',     0),
  (16, 1, 'Rosemary',  0),
  (16, 2, 'Mint',      1),
  (16, 3, 'Sage',      0),

  (17, 0, 'A spice blend', 0),
  (17, 1, 'A market',      1),
  (17, 2, 'A dance',       0),
  (17, 3, 'A festival',    0),

  (18, 0, 'Sushi',   0),
  (18, 1, 'Tagine',  1),
  (18, 2, 'Goulash', 0),
  (18, 3, 'Paella',  0),

  (19, 0, 'Minimalism',                       0),
  (19, 1, 'Bright colors and intricate patterns',1),
  (19, 2, 'Monochrome designs',               0),
  (19, 3, 'Abstract shapes',                  0),

  (20, 0, 'Baklava',   1),
  (20, 1, 'Croissant', 0),
  (20, 2, 'Macaron',   0),
  (20, 3, 'Doughnut',  0);

-- ---- Turkish ----
INSERT INTO quiz_questions (culture_id, sort_order, question) VALUES
  ('turkish', 0, 'What glass shape is traditional for Turkish tea?'),
  ('turkish', 1, 'What is the Grand Bazaar?'),
  ('turkish', 2, 'Which craft is Turkey famous for?'),
  ('turkish', 3, 'What is a common theme in Turkish art?'),
  ('turkish', 4, 'Which of these is a traditional Turkish dish?');

INSERT INTO quiz_choices (question_id, choice_order, choice_text, is_correct) VALUES
  (21, 0, 'Square',       0),
  (21, 1, 'Tulip-shaped', 1),
  (21, 2, 'Cylinder',     0),
  (21, 3, 'Bowl',         0),

  (22, 0, 'A palace',   0),
  (22, 1, 'A market',   1),
  (22, 2, 'A mosque',   0),
  (22, 3, 'A festival', 0),

  (23, 0, 'Origami',       0),
  (23, 1, 'Iznik tiles',   1),
  (23, 2, 'Pottery',       0),
  (23, 3, 'Kilim weaving', 0),

  (24, 0, 'Nature and geometry',    1),
  (24, 1, 'Abstract expressionism', 0),
  (24, 2, 'Minimalism',             0),
  (24, 3, 'Pop culture',            0),

  (25, 0, 'Sushi', 0),
  (25, 1, 'Kebab', 1),
  (25, 2, 'Pizza', 0),
  (25, 3, 'Taco',  0);

-- ---- Chinese ----
INSERT INTO quiz_questions (culture_id, sort_order, question) VALUES
  ('chinese', 0, 'Which festival uses red lanterns and dragon dances?'),
  ('chinese', 1, 'What drink is central to Chinese culture?'),
  ('chinese', 2, 'What does the dragon often symbolize?'),
  ('chinese', 3, 'Which of these is a traditional Chinese art form?'),
  ('chinese', 4, 'What is a common theme in Chinese festivals?');

INSERT INTO quiz_choices (question_id, choice_order, choice_text, is_correct) VALUES
  (26, 0, 'Diwali',          0),
  (26, 1, 'Chinese New Year', 1),
  (26, 2, 'Carnival',        0),
  (26, 3, 'Hanami',          0),

  (27, 0, 'Coffee', 0),
  (27, 1, 'Tea',    1),
  (27, 2, 'Soda',   0),
  (27, 3, 'Wine',   0),

  (28, 0, 'Luck and power', 1),
  (28, 1, 'Sadness',        0),
  (28, 2, 'Silence',        0),
  (28, 3, 'Speed',          0),

  (29, 0, 'Calligraphy', 1),
  (29, 1, 'Origami',     0),
  (29, 2, 'Mosaic',      0),
  (29, 3, 'Graffiti',    0),

  (30, 0, 'Family and renewal',          1),
  (30, 1, 'Individual achievement',      0),
  (30, 2, 'Sports and competition',      0),
  (30, 3, 'Technology and innovation',   0);

-- ---- Indian ----
INSERT INTO quiz_questions (culture_id, sort_order, question) VALUES
  ('indian', 0, 'Which celebration uses colored powder and joy?'),
  ('indian', 1, 'What is a common element in Indian cooking?'),
  ('indian', 2, 'Which Indian dance style is classical?'),
  ('indian', 3, 'What is a common theme in Indian festivals?'),
  ('indian', 4, 'Which of these is a popular Indian street food?');

INSERT INTO quiz_choices (question_id, choice_order, choice_text, is_correct) VALUES
  (31, 0, 'Diwali',   0),
  (31, 1, 'Holi',     1),
  (31, 2, 'Ramadan',  0),
  (31, 3, 'Carnival', 0),

  (32, 0, 'Chili spices', 1),
  (32, 1, 'Tortillas',    0),
  (32, 2, 'Soy sauce',    0),
  (32, 3, 'Wasabi',       0),

  (33, 0, 'Tango',  0),
  (33, 1, 'Kathak', 1),
  (33, 2, 'Salsa',  0),
  (33, 3, 'Hip hop',0),

  (34, 0, 'Family and spirituality',   1),
  (34, 1, 'Individual achievement',    0),
  (34, 2, 'Sports and competition',    0),
  (34, 3, 'Technology and innovation', 0),

  (35, 0, 'Samosa',  1),
  (35, 1, 'Pizza',   0),
  (35, 2, 'Taco',    0),
  (35, 3, 'Baguette',0);

-- ---- Norwegian ----
INSERT INTO quiz_questions (culture_id, sort_order, question) VALUES
  ('norwegian', 0, 'What is a fjord?'),
  ('norwegian', 1, 'What is "friluftsliv" about?'),
  ('norwegian', 2, 'Which historical group is associated with Norway?'),
  ('norwegian', 3, 'What is a common theme in Norwegian culture?'),
  ('norwegian', 4, 'Which of these is a traditional Norwegian dish?');

INSERT INTO quiz_choices (question_id, choice_order, choice_text, is_correct) VALUES
  (36, 0, 'A traditional hut',     0),
  (36, 1, 'A narrow coastal inlet',1),
  (36, 2, 'A festival',            0),
  (36, 3, 'A folk dance',          0),

  (37, 0, 'Indoor cooking', 0),
  (37, 1, 'Outdoor life',   1),
  (37, 2, 'A winter sport', 0),
  (37, 3, 'A folk song',    0),

  (38, 0, 'Samurai', 0),
  (38, 1, 'Vikings', 1),
  (38, 2, 'Incas',   0),
  (38, 3, 'Mongols', 0),

  (39, 0, 'Family and nature',          1),
  (39, 1, 'Individual achievement',     0),
  (39, 2, 'Sports and competition',     0),
  (39, 3, 'Technology and innovation',  0),

  (40, 0, 'Sushi',    0),
  (40, 1, 'Lutefisk', 1),
  (40, 2, 'Pizza',    0),
  (40, 3, 'Taco',     0);

-- ============================================================
--  USEFUL VIEWS
-- ============================================================

-- Full quiz question with its correct answer text
CREATE VIEW v_quiz_questions_with_answers AS
SELECT
  q.id            AS question_id,
  q.culture_id,
  q.sort_order,
  q.question,
  c.id            AS correct_choice_id,
  c.choice_text   AS correct_answer
FROM quiz_questions q
JOIN quiz_choices c
  ON c.question_id = q.id AND c.is_correct = 1;

-- Leaderboard: top users by XP
CREATE VIEW v_leaderboard AS
SELECT
  u.id,
  u.username,
  p.xp,
  p.cultures_completed,
  p.streak_days
FROM users u
JOIN user_progress p ON p.user_id = u.id
ORDER BY p.xp DESC;

-- Per-culture quiz accuracy for a user
CREATE VIEW v_user_culture_stats AS
SELECT
  a.user_id,
  a.culture_id,
  COUNT(*)                          AS attempts,
  ROUND(AVG(a.score / a.total * 100), 1) AS avg_accuracy_pct,
  MAX(a.score)                      AS best_score,
  SUM(a.xp_earned)                  AS total_xp
FROM quiz_attempts a
GROUP BY a.user_id, a.culture_id;
