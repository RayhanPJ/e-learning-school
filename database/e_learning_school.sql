-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Des 2024 pada 11.25
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `e_learning_school`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `major`
--

CREATE TABLE `major` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `major`
--

INSERT INTO `major` (`id`, `name`, `price`) VALUES
(1, 'Informatika', 1000),
(2, 'Mesin', 2000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `optionA` varchar(255) NOT NULL,
  `optionB` varchar(255) NOT NULL,
  `optionC` varchar(255) NOT NULL,
  `optionD` varchar(255) NOT NULL,
  `correctAns` varchar(255) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `questions`
--

INSERT INTO `questions` (`id`, `title`, `optionA`, `optionB`, `optionC`, `optionD`, `correctAns`, `score`) VALUES
(8, 'Q1', 'A', 'B', 'C', 'D', 'D', 10),
(9, 'Q2', 'A', 'B', 'C', 'D', 'D', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `question_test_mapping`
--

CREATE TABLE `question_test_mapping` (
  `question_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `question_test_mapping`
--

INSERT INTO `question_test_mapping` (`question_id`, `test_id`) VALUES
(8, 3),
(9, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `registers`
--

CREATE TABLE `registers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone` varchar(20) NOT NULL,
  `major_id` int(11) NOT NULL,
  `status_payment` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `registers`
--

INSERT INTO `registers` (`id`, `name`, `date_of_birth`, `phone`, `major_id`, `status_payment`) VALUES
(1, 'Rayhan', '2024-12-02', '123123123', 1, 1),
(2, 'Putra', '2024-12-02', '123123123', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `score`
--

CREATE TABLE `score` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `correct_count` int(11) NOT NULL,
  `wrong_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `score`
--

INSERT INTO `score` (`id`, `test_id`, `question_id`, `correct_count`, `wrong_count`) VALUES
(2, 3, 8, 0, 0),
(3, 3, 9, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'PENDING'),
(2, 'RUNNING'),
(3, 'COMPLETED');

-- --------------------------------------------------------

--
-- Struktur dari tabel `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `rollno` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `score` int(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `students`
--

INSERT INTO `students` (`id`, `test_id`, `rollno`, `username`, `password`, `score`, `status`, `role`) VALUES
(1, 3, 1, 'rayhan', 'KRqYsFd3', 0, 0, 'student'),
(2, 3, 2, 'putra', '8a7ShFH3', 0, 0, 'student');

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_data`
--

CREATE TABLE `student_data` (
  `id` int(11) NOT NULL,
  `rollno` bigint(20) NOT NULL,
  `major_id` int(11) NOT NULL,
  `registers_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `student_data`
--

INSERT INTO `student_data` (`id`, `rollno`, `major_id`, `registers_id`) VALUES
(1, 2, 1, 1),
(2, 3, 1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `teachers`
--

INSERT INTO `teachers` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'role');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `major_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tests`
--

INSERT INTO `tests` (`id`, `teacher_id`, `name`, `date`, `status_id`, `subject`, `total_questions`, `major_id`) VALUES
(3, 1, 'testss', '2024-12-02', 2, '123asdasd', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `question_test_mapping`
--
ALTER TABLE `question_test_mapping`
  ADD PRIMARY KEY (`question_id`,`test_id`),
  ADD KEY `question_test_mapping_fk1` (`test_id`);

--
-- Indeks untuk tabel `registers`
--
ALTER TABLE `registers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registers_fk0` (`major_id`);

--
-- Indeks untuk tabel `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`id`),
  ADD KEY `score_fk0` (`test_id`),
  ADD KEY `score_fk1` (`question_id`);

--
-- Indeks untuk tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students_fk0` (`test_id`),
  ADD KEY `students_fk1` (`rollno`);

--
-- Indeks untuk tabel `student_data`
--
ALTER TABLE `student_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_data_fk0` (`major_id`),
  ADD KEY `student_data_fk1` (`registers_id`);

--
-- Indeks untuk tabel `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tests_fk0` (`teacher_id`),
  ADD KEY `tests_fk1` (`status_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `major`
--
ALTER TABLE `major`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `registers`
--
ALTER TABLE `registers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `score`
--
ALTER TABLE `score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `student_data`
--
ALTER TABLE `student_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `question_test_mapping`
--
ALTER TABLE `question_test_mapping`
  ADD CONSTRAINT `question_test_mapping_fk0` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `question_test_mapping_fk1` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`);

--
-- Ketidakleluasaan untuk tabel `registers`
--
ALTER TABLE `registers`
  ADD CONSTRAINT `registers_fk0` FOREIGN KEY (`major_id`) REFERENCES `major` (`id`);

--
-- Ketidakleluasaan untuk tabel `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_fk0` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`),
  ADD CONSTRAINT `score_fk1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Ketidakleluasaan untuk tabel `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_fk0` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`);

--
-- Ketidakleluasaan untuk tabel `student_data`
--
ALTER TABLE `student_data`
  ADD CONSTRAINT `student_data_fk0` FOREIGN KEY (`major_id`) REFERENCES `major` (`id`),
  ADD CONSTRAINT `student_data_fk1` FOREIGN KEY (`registers_id`) REFERENCES `registers` (`id`);

--
-- Ketidakleluasaan untuk tabel `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_fk0` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`),
  ADD CONSTRAINT `tests_fk1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);
COMMIT;
