-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Úte 22. bře 2016, 21:43
-- Verze serveru: 10.1.9-MariaDB
-- Verze PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `kalendar`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `akce`
--

CREATE TABLE `akce` (
  `id_akce` int(10) UNSIGNED NOT NULL,
  `nazev` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `datum` date DEFAULT NULL,
  `popis` text COLLATE utf8_czech_ci,
  `kategorie` enum('hudba','divadlo','výstava','kino') COLLATE utf8_czech_ci DEFAULT NULL,
  `hodnoceni` decimal(2,1) DEFAULT '3.0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `akce`
--

INSERT INTO `akce` (`id_akce`, `nazev`, `datum`, `popis`, `kategorie`, `hodnoceni`) VALUES
(1, 'Veletrh PRAGUE PHOTO', '0000-00-00', 'Veletrh PRAGUE PHOTO nabídne svým návštěvníkům originální díla ikon české fotografie – Sudek, Funke, Rössler, Chochola, Ludwig, Lauschmann, dále díla současných autorů - Saudek, Stano, Bláhová, Gabina, Cudlín, Šimánek, Stach aj. Veletrh představí rovněž tvorbu absolventů a studentů uměleckých škol. Doprovodný program zahrnuje projekce, panely, prezentace.', 'hudba', '3.6'),
(2, 'Hudba severských autorů', '2009-04-14', 'Hudba severských autorů zazní na podiu Dvořákovy síně. Česká filharmonie představí díla Leifse, Aho, Nielsena. Dirigovat bude finský umělec Osmo Vänskä. Navštivte nás 2. nebo 3. dubna, vstupenky jsou v prodeji v pokladně Rudolfina.', 'hudba', '4.0'),
(4, 'Abonentní koncert České filharmonie', '2009-04-09', 'Již 7. koncert abonentních cyklů E a F České filharmonie bude ve dnech 9. a 10. dubna v Rudolfinu řídit její bývalý  šéfdirigent Gerd Albrecht.', 'hudba', '2.0'),
(6, 'Historie výroby čokolády', '2009-04-13', 'Historie, pěstování a výroba čokolády v Českých zemích a prezentace čokoládoven v ČR, ochutnávka a předvádění výroby čokolády. Unikátní galerie obrazů malovaných čokoládou od světoznámého umělce Vladomíra Čecha.', 'výstava', '4.0'),
(13, 'Blbec k večeři (F. Veber)', '2009-04-13', 'V této bláznivé francouzské komedii platí, že „kdo jinému jámu kopá, sám do ní padá“ a „kdo se směje naposled, ten se směje nejlíp“. Hrají: V. Vydra, V. Freimanová/J. Boušková, J. Carda, R. Hrušínský, J. Švandová/N. Urbánková, J. Menzel/Z. Žák. Divadlo Na zábradlí od 18 hodin.', 'divadlo', '2.5'),
(15, 'Hrdý Budžes (I. Dousková)', '2009-04-10', 'Host Divadlo A. Dvořáka Příbram - v hlavní roli Barbora Hrzánová\r\nSkvělá tragikomedie o prvních letech husákovské normalizace „očima“ zvídavé žákyně druhé třídy ZDŠ, Heleny Součkové. Hrají: B. Hrzánová (oceněna za tuto roli Thalií 2003), J. Vlčková/M. Šiková, L. Jeník. Divadlo Bez zábradlí od 20 hodin', 'divadlo', '3.0');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `akce`
--
ALTER TABLE `akce`
  ADD PRIMARY KEY (`id_akce`),
  ADD KEY `nazev` (`nazev`),
  ADD KEY `datum` (`datum`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `akce`
--
ALTER TABLE `akce`
  MODIFY `id_akce` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
