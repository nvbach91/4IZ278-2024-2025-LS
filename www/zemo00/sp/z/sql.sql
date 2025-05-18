CREATE TABLE sp_users(
	user_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    privilege INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sp_gamemodes(
	mode_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(32) NOT NULL UNIQUE,
    description VARCHAR(255)
);

CREATE TABLE sp_games(
	game_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    mode INT(11) NOT NULL,
    user_id INT (11) NOT NULL,
    CONSTRAINT fk_game_gamemode
    	FOREIGN KEY (mode)
    	REFERENCES sp_gamemodes(mode_id),
    CONSTRAINT fk_game_user
    	FOREIGN KEY (user_id)
    	REFERENCES sp_users(user_id)
);

CREATE TABLE sp_languages(
	code VARCHAR(5) PRIMARY KEY,
    name VARCHAR(32) NOT NULL UNIQUE,
    icon VARCHAR(255) NULL
);

CREATE TABLE sp_words(
	word_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    word VARCHAR(32) NOT NULL,
    lang_code VARCHAR(5) NOT NULL,
    CONSTRAINT fk_word_lang
    	FOREIGN KEY lang_code
        REFERENCES sp_languages(code)
);

CREATE TABLE sp_game_words(
    game_id INT(11) NOT NULL,
    word_id INT(11) NOT NULL,
    correct TINYINT(1) NOT NULL,
    CONSTRAINT fk_gamewords_game
        FOREIGN KEY (game_id)
        REFERENCES sp_games(game_id),
    CONSTRAINT fk_gamewords_words
        FOREIGN KEY (word_id)
        REFERENCES sp_words(word_id),
    CONSTRAINT pk_gamewords
        PRIMARY KEY (game_id, word_id)
);

CREATE TABLE sp_collections(
    collection_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(32) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_id INT(11) NOT NULL,
    CONSTRAINT fk_coll_user
        FOREIGN KEY (user_id)
        REFERENCES sp_users(user_id)
);

CREATE TABLE sp_collection_words(
    collection_id INT(11) NOT NULL,
    word_id INT (11) NOT NULL,
    CONSTRAINT fk_collectionwords_coll
        FOREIGN KEY (collection_id)
        REFERENCES sp_collections(collection_id),
    CONSTRAINT fk_collectionwords_words
        FOREIGN KEY (word_id)
        REFERENCES sp_words(word_id),
    CONSTRAINT pk_collectionwords
        PRIMARY KEY (collection_id, word_id)
);

CREATE TABLE sp_concepts(
    concept_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(32) NOT NULL,
    description VARCHAR(255) NULL
);

CREATE TABLE sp_word_concepts(
    word_id INT(11) NOT NULL,
    concept_id INT(11) NOT NULL,
    CONSTRAINT fk_wordconcepts_words
        FOREIGN KEY (word_id)
        REFERENCES sp_words(word_id),
    CONSTRAINT fk_wordconcepts_concepts
        FOREIGN KEY (concept_id)
        REFERENCES sp_concepts(concept_id),
    CONSTRAINT pk_wordconcepts
        PRIMARY KEY (word_id, concept_id)
);

CREATE TABLE sp_categories(
    name VARCHAR(32) PRIMARY KEY,
    description VARCHAR(255) NULL,
    icon VARCHAR(255) NULL
);

CREATE TABLE sp_concept_categories(
    concept_id INT(11) NOT NULL,
    category_name VARCHAR(32) NOT NULL,
    CONSTRAINT fk_conceptcategories_concepts
        FOREIGN KEY (concept_id)
        REFERENCES sp_concepts(concept_id),
    CONSTRAINT fk_conceptcategories_categories
        FOREIGN KEY (category_name)
        REFERENCES sp_categories(name)
);