CREATE TABLE Utilisateur(
    id_user int AUTO_INCREMENT PRIMARY KEY,
    username varchar(50) NOT NULL UNIQUE,
    email varchar(100) NOT NULL UNIQUE,
    passworde varchar(300) NOT NULL,
    createdAt timestamp DEFAULT CURRENT_TIMESTAMP,
    lastLogin DATETIME DEFAULT NULL,
    role ENUM('BasicUser','ProUser','Administrateur','Moderator') NOT null,
    urlphoto varchar(200) DEFAULT null,
    biographie varchar(1000) DEFAULT null,
    uploadCount int DEFAULT 0,
    subscriptionStart DateTime DEFAULT null ,
    subscriptionEnd DateTime DEFAULT null,
    level ENUM('junior','senior','lead') DEFAULT null,
    isSuperAdmin boolean DEFAULT null
);
CREATE TABLE Photo(
    id_photo int AUTO_INCREMENT PRIMARY KEY,
    titre varchar(200) NOT NULL,
    description varchar(2000) DEFAULT null,
    name varchar(50) UNIQUE NOT NULL,
    taille int NOT NULL CHECK (taille<=10000000),
    url varchar(300) NOT NULL,
    dimensions varchar(50) NOT NULL,
    statut ENUM('Publié','brouillon','archivé') DEFAULT "brouillon",
    createdAt timestamp DEFAULT CURRENT_TIMESTAMP,
    publishedAt datetime DEFAULT null,
    uploadAt datetime DEFAULT null,
    viewCount int DEFAULT 0,
    id_user int NOT null,
    FOREIGN key (id_user) REFERENCES Utilisateur(id_user) ON DELETE CASCADE
);
CREATE TABLE Album(
    id_album int AUTO_INCREMENT PRIMARY KEY,
    nom varchar(100) NOT NULL,
    description varchar(1000) DEFAULT null,
    coverphoto_id INT DEFAULT NULL,
    createdAt timestamp DEFAULT CURRENT_TIMESTAMP,
    uploadAt datetime DEFAULT null,   
    photoCount int DEFAULT 0 CHECK (photoCount<100),
    Paramètrebinaire ENUM('public','privé') NOT null ,
    id_user int NOT null,
    FOREIGN KEY (coverphoto_id) REFERENCES Photo(id_photo),
    FOREIGN key (id_user) REFERENCES Utilisateur(id_user) ON DELETE CASCADE,
    UNIQUE(nom,id_user)
);
CREATE TABLE Album_Photo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    album_id INT NOT NULL,
    photo_id INT NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (album_id) REFERENCES Album(id_album) ON DELETE CASCADE,
    FOREIGN KEY (photo_id) REFERENCES Photo(id_photo) ON DELETE CASCADE,
    UNIQUE(album_id, photo_id) 
);

CREATE TABLE Tag(
    id_tag int AUTO_INCREMENT PRIMARY KEY,
    nom varchar(50) NOT NULL UNIQUE COLLATE utf8_general_ci,
    URLfriendly varchar(100) NOT NULL ,
    photoCount int DEFAULT 0
);
CREATE TABLE Tagueé(
    id_t int AUTO_INCREMENT PRIMARY KEY,
    id_photo int NOT null,
    id_tag int NOT null,
	createdAt timestamp DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_photo) REFERENCES Photo(id_photo) ON DELETE CASCADE,
    FOREIGN KEY (id_tag) REFERENCES Tag(id_tag) ON DELETE CASCADE,
    UNIQUE (id_photo,id_tag)
);
CREATE TABLE Commentaire(
    id_commentaire int AUTO_INCREMENT PRIMARY KEY,
    Contenu varchar(505) NOT NULL,
    id_user int not null,
    id_photo int not null,
    createdAt timestamp DEFAULT CURRENT_TIMESTAMP,
    lastUpdate datetime DEFAULT null,
    FOREIGN KEY (id_user) REFERENCES Utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_photo) REFERENCES Photo(id_photo) ON DELETE CASCADE
);
CREATE TABLE Likes(
    id_like int AUTO_INCREMENT PRIMARY KEY,
    id_user int not null,
    id_photo int not null,
    createdAt timestamp DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES Utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_photo) REFERENCES Photo(id_photo) ON DELETE CASCADE,
    UNIQUE(id_user,id_photo)
);


