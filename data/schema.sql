-- база данных
CREATE DATABASE IF NOT EXISTS coursework DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE coursework;

-- БД товаров
CREATE TABLE goods (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,           -- id товара
  title varchar(60) NOT NULL,                               -- заголовок товара
  price int(11) NOT NULL,                                   -- цена товара
  description text NOT NULL,                                -- описание товара
  FULLTEXT (title)
);

-- БД пользователей
CREATE TABLE users (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,           -- id пользователя
  date_now datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,     -- дата регистрации
  birthday date NOT NULL,                                   -- дата дня рождения
  username varchar(25) NOT NULL,                            -- имя пользователя
  mail varchar(60) NOT NULL UNIQUE,                         -- маил
  password varchar(70) NOT NULL                             -- пароль
);

-- БД праздников
CREATE TABLE holidays (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,           -- id празника
  date DATE,                                                -- дата празника
  holiday varchar(40) NOT NULL,                             -- название праздника
  discount int(4) NOT NULL                                  -- скидка в праздник
);

-- БД бонусных карт
CREATE TABLE bonus_cards (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,           -- id карты
  id_user int(11) NOT NULL,                                 -- id пользователя
  сard_number char(16) NOT NULL UNIQUE,                     -- номер карты
  date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,         -- дата регистрации
  balance int(5) NOT NULL DEFAULT 0,                        -- количество бонусов
  FOREIGN KEY (id_user) REFERENCES users(id)
);

-- БД акций
CREATE TABLE stock (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,           -- id акции
  id_good int(11) NOT NULL,                                 -- id товара
  discount int(4) NOT NULL DEFAULT 0,                       -- размер скидки
  bonuses int(4) NOT NULL DEFAULT 0,                        -- размер бонусов
  data_start DATE NOT NULL,                                 -- дата начала акции
  data_end DATE NOT NULL,                                   -- дата окончания акции
  FOREIGN KEY (id_good) REFERENCES goods(id)
);

-- БД опросов
CREATE TABLE polls (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,           -- id опроса
  name_poll varchar(50) NOT NULL,                           -- тема опроса
  status BIT NOT NULL DEFAULT 1,                            -- статус опроса
  data_end DATE NOT NULL                                    -- дата окончания опроса
);

-- БД вопросов к опросу
CREATE TABLE questions (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,           -- id вопроса
  id_poll int(11) NOT NULL,                                 -- id опроса
  description text NOT NULL,                                -- вопрос
  FOREIGN KEY (id_poll) REFERENCES polls(id)
);

-- БД результатов опросов
CREATE TABLE survey_results (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,           -- id ответа
  id_question int(11) NOT NULL,                             -- id вопроса
  id_user int(11) NOT NULL,                                 -- id пользователя
  answer varchar(50) NOT NULL,                              -- ответ на вопрос
  FOREIGN KEY (id_question) REFERENCES questions(id),
  FOREIGN KEY (id_user) REFERENCES users(id)
);

-- БД заказов
CREATE TABLE orders (
  id int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,           -- id заказа
  id_user int(10) NOT NULL,                                 -- id пользователя
  amount float(8,2) NOT NULL,                               -- сумма заказа
  date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,         -- время заказа
  FOREIGN KEY (id_user) REFERENCES users(id)
);

-- БД элементов заказов
CREATE TABLE order_items (
  id int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,           -- id элемента заказа
  id_order int(10) NOT NULL,                                -- id заказа
  id_good int(10) NOT NULL,                                 -- id товара
  quantity tinyint(3) NOT NULL,                             -- количество товара
  FOREIGN KEY (id_order) REFERENCES orders(id),
  FOREIGN KEY (id_good) REFERENCES goods(id)
);

-- БД премиум пользователей
CREATE TABLE premium_users (
  id_user int(10) NOT NULL,                                 -- id пользователя
  data_start DATE NOT NULL,                                 -- дата начала
  data_end DATE NOT NULL,                                   -- дата окончания премиума
  FOREIGN KEY (id_user) REFERENCES users(id)
);

-- БД по цене "3 по цене 2"
CREATE TABLE by_price (
  id int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,           -- id акции
  id_good int(10) NOT NULL,                                 -- id товара
  number int(2) NOT NULL,                                   -- количество
  data_start DATE NOT NULL,                                 -- дата начала акции
  data_end DATE NOT NULL,                                   -- дата окончания акции
  FOREIGN KEY (id_good) REFERENCES goods(id)
);

-- БД корзина покупателя
CREATE TABLE shopping_cart (
  id_user int(10) NOT NULL,                                 -- id пользователя
  id_good int(10) NOT NULL,                                 -- id товара
  number int(2) NOT NULL DEFAULT 1,                         -- количество
  FOREIGN KEY (id_user) REFERENCES users(id),
  FOREIGN KEY (id_good) REFERENCES goods(id)
);
