-- SQL code to create tables based on the provided ER diagram

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    difficulty VARCHAR(50),
    cooktime INT,
    portions INT,
    img VARCHAR(255),
    deleted INT DEFAULT 0,
    owner_user_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_user_id) REFERENCES users(id)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(50)
);

CREATE TABLE recipe_categories (
    recipe_id INT,
    category_id INT,
    PRIMARY KEY (recipe_id, category_id),
    FOREIGN KEY (recipe_id) REFERENCES recipes(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE recipe_steps (
    recipe_id INT,
    step_num INT NOT NULL,
    step_description VARCHAR(1000) NOT NULL,
    PRIMARY KEY (recipe_id, step_num),
    FOREIGN KEY (recipe_id) REFERENCES recipes(id)
);

CREATE TABLE ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(255),
    deleted INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE units (
    id INT AUTO_INCREMENT PRIMARY KEY,
    unit_name VARCHAR(100) NOT NULL,
    unit_shortname VARCHAR(20)
);

CREATE TABLE ingredients_units (
    ingredient_id INT,
    unit_id INT,
    PRIMARY KEY (ingredient_id, unit_id),
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id),
    FOREIGN KEY (unit_id) REFERENCES units(id)
);

CREATE TABLE recipe_ingredients (
    recipe_id INT,
    ingredient_id INT,
    PRIMARY KEY (recipe_id, ingredient_id),
    FOREIGN KEY (recipe_id) REFERENCES recipes(id),
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id)
);

CREATE TABLE user_favorites (
    user_id INT,
    recipe_id INT,
    PRIMARY KEY (user_id, recipe_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (recipe_id) REFERENCES recipes(id)
);
