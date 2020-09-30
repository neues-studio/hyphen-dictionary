CREATE TABLE tx_hyphendictionary_item (
    word varchar(80) DEFAULT '' NOT NULL,
    word_length tinyint unsigned DEFAULT '0' NOT NULL,
    hyphenated_word varchar(255) DEFAULT '' NOT NULL,
    rowDescription text
);
