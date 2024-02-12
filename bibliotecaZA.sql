CREATE DATABASE IF NOT EXISTS bibliotecaZA;
USE bibliotecaZA;

CREATE TABLE IF NOT EXISTS usuarios (
    email VARCHAR(60) PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL
);

ALTER TABLE usuarios ADD COLUMN rol VARCHAR(20) NOT NULL DEFAULT 'socio';


CREATE TABLE IF NOT EXISTS libros (
    ISBN VARCHAR(10) PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    genero ENUM('Ficción', 'No Ficción', 'Ciencia Ficción', 'Misterio', 'Romance', 'Aventura', 'Fantasía', 'Drama', 'Poesía', 'Biografía', 'Histórico', 'Thriller', 'Humor', 'Infantil', 'Otro') NOT NULL,
    puntuacion_media FLOAT NOT NULL,
    nivel_lectura ENUM('primaria', '1eso', '2eso', '3eso', '4eso', '1bach', '2bach', 'avanzado')
);

/*CREATE TABLE IF NOT EXISTS prestamos (
    ISBN VARCHAR(10),
    email_usuario VARCHAR(60),
    fecha_prestamo DATE NOT NULL,
    fecha_devolucion DATE,
    PRIMARY KEY (ISBN, email_usuario),
    FOREIGN KEY (ISBN) REFERENCES libros(ISBN),
    FOREIGN KEY (email_usuario) REFERENCES usuarios(email)
);
*/

CREATE TABLE IF NOT EXISTS valoraciones (
    ISBN VARCHAR(10),
    email_usuario VARCHAR(60),
    puntuacion ENUM('1 estrella', '2 estrellas', '3 estrellas', '4 estrellas', '5 estrellas'),
    comentario TEXT,
    fecha_valoracion DATE NOT NULL,
    PRIMARY KEY (ISBN, email_usuario),
    FOREIGN KEY (ISBN) REFERENCES libros(ISBN),
    FOREIGN KEY (email_usuario) REFERENCES usuarios(email)
);

INSERT INTO libros (ISBN, titulo, autor, genero, puntuacion_media, nivel_lectura) VALUES
('1234567890', 'Cien años de soledad', 'Gabriel García Márquez', 'Ficción', 4.5, 'avanzado'),
('9876543210', '1984', 'George Orwell', 'Ciencia Ficción', 4.2, 'avanzado'),
('1112223330', 'To Kill a Mockingbird', 'Harper Lee', 'Drama', 4.8, '2bach'),
('4445556660', 'The Great Gatsby', 'F. Scott Fitzgerald', 'Romance', 4.0, '2bach'),
('7778889990', 'Pride and Prejudice', 'Jane Austen', 'Romance', 4.7, '2bach'),
('1212121212', 'The Hobbit', 'J.R.R. Tolkien', 'Fantasía', 4.9, 'avanzado'),
('3434343434', 'One Hundred Years of Solitude', 'Gabriel García Márquez', 'Ficción', 4.6, 'avanzado'),
('5656565656', 'Brave New World', 'Aldous Huxley', 'Ciencia Ficción', 4.1, 'avanzado'),
('7878787878', 'The Catcher in the Rye', 'J.D. Salinger', 'Drama', 4.3, '2bach'),
('9090909090', 'The Lord of the Rings', 'J.R.R. Tolkien', 'Fantasía', 4.9, 'avanzado'),
('2323232323', 'Crime and Punishment', 'Fyodor Dostoevsky', 'Misterio', 4.5, 'avanzado'),
('4545454545', 'The Shining', 'Stephen King', 'Terror', 4.4, 'avanzado'),
('6767676767', 'The Da Vinci Code', 'Dan Brown', 'Misterio', 4.2, 'avanzado'),
('8989898989', 'The Alchemist', 'Paulo Coelho', 'Aventura', 4.8, '2bach'),
('1010101010', 'The Odyssey', 'Homer', 'Aventura', 4.7, 'avanzado'),
('1212121210', 'The Kite Runner', 'Khaled Hosseini', 'Drama', 4.6, '2bach'),
('3030303030', 'Manifiesto Comunista', 'Karl Marx', 'Histórico', 4.6, 'avanzado'),
('1414141414', 'Harry Potter and the Sorcerers Stone', 'J.K. Rowling', 'Fantasía', 4.9, '2bach'),
('1616161619', 'The Hitchhikers Guide to the Galaxy', 'Douglas Adams', 'Ciencia Ficción', 4.5, 'avanzado'),
('1818181818', 'Frankenstein', 'Mary Shelley', 'Terror', 4.3, '2bach'),
('2020202020', 'The Chronicles of Narnia', 'C.S. Lewis', 'Fantasía', 4.8, 'avanzado');

