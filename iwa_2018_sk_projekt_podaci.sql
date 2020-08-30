SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
USE `iwa_2018_sk_projekt` ;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Dumping data for table `tip_korisnika`
--

INSERT INTO `tip_korisnika` (`tip_id`, `naziv`) VALUES
(0, 'administrator'),
(1, 'voditelj'),
(2, 'korisnik');

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`korisnik_id`, `tip_id`, `korisnicko_ime`, `lozinka`, `ime`, `prezime`, `email`, `slika`) VALUES
(1, 0, 'admin', 'foi', 'Administrator', 'Admin', 'admin@foi.hr', 'korisnici/admin.jpg'),
(2, 1, 'voditelj', '123456', 'voditelj', 'Vodi', 'voditelj@foi.hr', 'korisnici/admin.jpg'),
(3, 2, 'pkos', '123456', 'Pero', 'Kos', 'pkos@fff.hr', 'korisnici/pkos.jpg'),
(4, 2, 'vzec', '123456', 'Vladimir', 'Zec', 'vzec@fff.hr', 'korisnici/vzec.jpg'),
(5, 2, 'qtarantino', '123456', 'Quentin', 'Tarantino', 'qtarantino@foi.hr', 'korisnici/qtarantino.jpg'),
(6, 2, 'mbellucci', '123456', 'Monica', 'Bellucci', 'mbellucci@foi.hr', 'korisnici/mbellucci.jpg'),
(7, 2, 'vmortensen', '123456', 'Viggo', 'Mortensen', 'vmortensen@foi.hr', 'korisnici/vmortensen.jpg'),
(8, 2, 'jgarner', '123456', 'Jennifer', 'Garner', 'jgarner@foi.hr', 'korisnici/jgarner.jpg'),
(9, 2, 'nportman', '123456', 'Natalie', 'Portman', 'nportman@foi.hr', 'korisnici/nportman.jpg'),
(10, 2, 'dradcliffe', '123456', 'Daniel', 'Radcliffe', 'dradcliffe@foi.hr', 'korisnici/dradcliffe.jpg'),
(11, 2, 'hberry', '123456', 'Halle', 'Berry', 'hberry@foi.hr', 'korisnici/hberry.jpg'),
(12, 2, 'vdiesel', '123456', 'Vin', 'Diesel', 'vdiesel@foi.hr', 'korisnici/vdiesel.jpg'),
(13, 2, 'ecuthbert', '123456', 'Elisha', 'Cuthbert', 'ecuthbert@foi.hr', 'korisnici/ecuthbert.jpg'),
(14, 2, 'janiston', '123456', 'Jennifer', 'Aniston', 'janiston@foi.hr', 'korisnici/janiston.jpg'),
(15, 2, 'ctheron', '123456', 'Charlize', 'Theron', 'ctheron@foi.hr', 'korisnici/ctheron.jpg'),
(16, 2, 'nkidman', '123456', 'Nicole', 'Kidman', 'nkidman@foi.hr', 'korisnici/nkidman.jpg'),
(17, 2, 'ewatson', '123456', 'Emma', 'Watson', 'ewatson@foi.hr', 'korisnici/ewatson.jpg'),
(18, 1, 'kdunst', '123456', 'Kirsten', 'Dunst', 'kdunst@foi.hr', 'korisnici/kdunst.jpg'),
(19, 2, 'sjohansson', '123456', 'Scarlett', 'Johansson', 'sjohansson@foi.hr', 'korisnici/sjohansson.jpg'),
(20, 2, 'philton', '123456', 'Paris', 'Hilton', 'philton@foi.hr', 'korisnici/philton.jpg'),
(21, 2, 'kbeckinsale', '123456', 'Kate', 'Beckinsale', 'kbeckinsale@foi.hr', 'korisnici/kbeckinsale.jpg'),
(22, 2, 'tcruise', '123456', 'Tom', 'Cruise', 'tcruise@foi.hr', 'korisnici/tcruise.jpg'),
(23, 2, 'hduff', '123456', 'Hilary', 'Duff', 'hduff@foi.hr', 'korisnici/hduff.jpg'),
(24, 2, 'ajolie', '123456', 'Angelina', 'Jolie', 'ajolie@foi.hr', 'korisnici/ajolie.jpg'),
(25, 2, 'kknightley', '123456', 'Keira', 'Knightley', 'kknightley@foi.hr', 'korisnici/kknightley.jpg'),
(26, 2, 'obloom', '123456', 'Orlando', 'Bloom', 'obloom@foi.hr', 'korisnici/obloom.jpg'),
(27, 2, 'llohan', '123456', 'Lindsay', 'Lohan', 'llohan@foi.hr', 'korisnici/llohan.jpg'),
(28, 2, 'jdepp', '123456', 'Johnny', 'Depp', 'jdepp@foi.hr', 'korisnici/jdepp.jpg'),
(29, 2, 'kreeves', '123456', 'Keanu', 'Reeves', 'kreeves@foi.hr', 'korisnici/kreeves.jpg'),
(30, 1, 'thanks', '123456', 'Tom', 'Hanks', 'thanks@foi.hr', 'korisnici/thanks.jpg'),
(31, 2, 'elongoria', '123456', 'Eva', 'Longoria', 'elongoria@foi.hr', 'korisnici/elongoria.jpg'),
(32, 2, 'rde', '123456', 'Robert', 'De', 'rde@foi.hr', 'korisnici/rde.jpg'),
(33, 2, 'jheder', '123456', 'Jon', 'Heder', 'jheder@foi.hr', 'korisnici/jheder.jpg'),
(34, 2, 'rmcadams', '123456', 'Rachel', 'McAdams', 'rmcadams@foi.hr', 'korisnici/rmcadams.jpg'),
(35, 2, 'cbale', '123456', 'Christian', 'Bale', 'cbale@foi.hr', 'korisnici/cbale.jpg'),
(36, 1, 'jalba', '123456', 'Jessica', 'Alba', 'jalba@foi.hr', 'korisnici/jalba.jpg'),
(37, 2, 'bpitt', '123456', 'Brad', 'Pitt', 'bpitt@foi.hr', 'korisnici/bpitt.jpg'),
(43, 2, 'apacino', '123456', 'Al', 'Pacino', 'apacino@foi.hr', 'korisnici/apacino.jpg'),
(44, 2, 'wsmith', '123456', 'Will', 'Smith', 'wsmith@foi.hr', 'korisnici/wsmith.jpg'),
(45, 2, 'ncage', '123456', 'Nicolas', 'Cage', 'ncage@foi.hr', 'korisnici/ncage.jpg'),
(46, 2, 'vanne', '123456', 'Vanessa', 'Anne', 'vanne@foi.hr', 'korisnici/vanne.jpg'),
(47, 2, 'kheigl', '123456', 'Katherine', 'Heigl', 'kheigl@foi.hr', 'korisnici/kheigl.jpg'),
(48, 2, 'gbutler', '123456', 'Gerard', 'Butler', 'gbutler@foi.hr', 'korisnici/gbutler.jpg'),
(49, 2, 'jbiel', '123456', 'Jessica', 'Biel', 'jbiel@foi.hr', 'korisnici/jbiel.jpg'),
(50, 2, 'ldicaprio', '123456', 'Leonardo', 'DiCaprio', 'ldicaprio@foi.hr', 'korisnici/ldicaprio.jpg'),
(51, 2, 'mdamon', '123456', 'Matt', 'Damon', 'mdamon@foi.hr', 'korisnici/mdamon.jpg'),
(52, 2, 'hpanettiere', '123456', 'Hayden', 'Panettiere', 'hpanettiere@foi.hr', 'korisnici/hpanettiere.jpg'),
(53, 2, 'rreynolds', '123456', 'Ryan', 'Reynolds', 'rreynolds@foi.hr', 'korisnici/rreynolds.jpg'),
(54, 2, 'jstatham', '123456', 'Jason', 'Statham', 'jstatham@foi.hr', 'korisnici/jstatham.jpg'),
(55, 2, 'enorton', '123456', 'Edward', 'Norton', 'enorton@foi.hr', 'korisnici/enorton.jpg'),
(56, 2, 'mwahlberg', '123456', 'Mark', 'Wahlberg', 'mwahlberg@foi.hr', 'korisnici/mwahlberg.jpg'),
(57, 2, 'jmcavoy', '123456', 'James', 'McAvoy', 'jmcavoy@foi.hr', 'korisnici/jmcavoy.jpg'),
(58, 2, 'epage', '123456', 'Ellen', 'Page', 'epage@foi.hr', 'korisnici/epage.jpg'),
(59, 2, 'mcyrus', '123456', 'Miley', 'Cyrus', 'mcyrus@foi.hr', 'korisnici/mcyrus.jpg'),
(60, 2, 'kstewart', '123456', 'Kristen', 'Stewart', 'kstewart@foi.hr', 'korisnici/kstewart.jpg'),
(61, 2, 'mfox', '123456', 'Megan', 'Fox', 'mfox@foi.hr', 'korisnici/mfox.jpg'),
(62, 2, 'slabeouf', '123456', 'Shia', 'LaBeouf', 'slabeouf@foi.hr', 'korisnici/slabeouf.jpg'),
(63, 2, 'ceastwood', '123456', 'Clint', 'Eastwood', 'ceastwood@foi.hr', 'korisnici/ceastwood.jpg'),
(64, 2, 'srogen', '123456', 'Seth', 'Rogen', 'srogen@foi.hr', 'korisnici/srogen.jpg'),
(65, 2, 'nreed', '123456', 'Nikki', 'Reed', 'nreed@foi.hr', 'korisnici/nreed.jpg'),
(66, 2, 'agreene', '123456', 'Ashley', 'Greene', 'agreene@foi.hr', 'korisnici/agreene.jpg'),
(67, 2, 'zdeschanel', '123456', 'Zooey', 'Deschanel', 'zdeschanel@foi.hr', 'korisnici/zdeschanel.jpg'),
(68, 2, 'dfanning', '123456', 'Dakota', 'Fanning', 'dfanning@foi.hr', 'korisnici/dfanning.jpg'),
(69, 2, 'tlautner', '123456', 'Taylor', 'Lautner', 'tlautner@foi.hr', 'korisnici/tlautner.jpg'),
(70, 2, 'rpattinson', '123456', 'Robert', 'Pattinson', 'rpattinson@foi.hr', 'korisnici/rpattinson.jpg');

--
-- Dumping data for table `parkiraliste`
--

INSERT INTO `parkiraliste` (`parkiraliste_id`, `naziv`, `adresa`, `slika`, `video`) VALUES
(1, 'Podzemna Garaža Kapucinski Trg', 'Kapucinski trg, 42000, Varaždin', 'http://lateramen.hr/wp-content/uploads/2014/11/013.jpg', ''),
(2, 'Parkiralište Gradska Tržnica Varaždin', 'Trg bana Josipa Jelačića, 42000, Varaždin', 'https://evarazdin.hr/upload/publish/355706/thumb/vijest-20citatelja1_57246372b1a0f_680x400c.jpg', ''),
(3, 'Parkiralište Grad Varaždin', 'Pavlinska ulica, 42000, Varaždin', 'http://prevoditelji-tumaci.com/wp-content/uploads/2015/05/prevoditelji-tumaci-1.jpg', ''),
(4, 'Parkiralište Opća Bolnica Varaždin', 'Ulica Ivana Meštrovića, 42000, Varaždin', 'www.varazdinske-vijesti.hr/media/k2/items/cache/8485e3aeefa20739eddf13606c9251f6_XL.jpg?t=1481050052', '');

--
-- Dumping data for table `tvrtka`
--

INSERT INTO `tvrtka` (`tvrtka_id`, `moderator_id`, `parkiraliste_id`, `naziv`, `opis`) VALUES
(1, 2, 1, 'HEP', 'Hrvatska Elektroprivreda'),
(2, 18, 1, 'INA', 'Industrija Nafte'),
(3, 30, 2, 'PBZ', 'Privredna Banka Zagreb'),
(4, 36, 3, 'MTČ', 'MTČ Tvornica Trikotaže');

--
-- Dumping data for table `partner`
--

INSERT INTO `partner` (`partner_id`, `korisnik_id`, `tvrtka_id`) VALUES
(1, 3, 1),
(2, 3, 2),
(3, 4, 3),
(4, 4, 4),
(5, 4, 1),
(6, 5, 2),
(7, 6, 3),
(8, 7, 4),
(9, 8, 1),
(10, 9, 2),
(11, 10, 3),
(12, 11, 4),
(13, 12, 1);

--
-- Dumping data for table `automobil`
--

INSERT INTO `automobil` (`automobil_id`, `partner_id`, `registracija`, `datum_vrijeme_dolaska` ,`datum_vrijeme_odlaska`) VALUES
(1, 1, 'VŽ-789-DS', '2018-10-01 07:00:00', '2018-10-01 15:25:00'),
(2, 1, 'VŽ-7166-EP', '2018-10-02 08:00:00', '2018-10-02 16:50:00'),
(3, 1, 'ZG-6482-TE', '2018-10-03 09:00:00', '2018-10-03 17:25:00'),
(4, 2, 'ZG-2186-AU', '2018-10-04 10:00:00', '2018-10-04 18:50:00'),
(5, 3, 'VU-7362-LJ', '2018-10-05 11:00:00', '2018-10-05 12:05:00'),
(6, 4, 'VT-1399-IN', '2018-10-06 12:00:00', '2018-10-06 13:10:00'),
(7, 5, 'VK-7634-CŠ', '2018-10-06 07:00:00', '2018-10-06 08:15:00'),
(8, 6, 'ŠI-2543-ČH', '2018-10-08 08:00:00', '2018-10-08 09:20:00'),
(9, 7, 'ST-166-ZJ', '2018-10-09 09:00:00', '2018-10-09 10:25:00'),
(10, 8, 'SL-4504-FŽ', '2018-10-10 10:00:00', '2018-10-10 12:30:00'),
(11, 9, 'SK-6634-MF', '2018-10-11 11:00:00', '2018-10-11 13:35:00'),
(12, 10, 'SB-1071-BA', '2018-10-12 12:00:00', '2018-10-12 14:40:00'),
(13, 11, 'RI-3226-RC', '2018-10-13 13:00:00', '2018-10-13 15:45:00'),
(14, 12, 'PŽ-551-IČ', '2018-10-15 14:00:00', '2018-10-15 16:50:00'),
(15, 13, 'PU-4813-DB', '2018-10-15 15:00:00', '2018-10-15 18:55:00'),
(16, 1, 'VŽ-789-DS', '2018-10-16 16:00:00', '2018-10-16 19:00:00'),
(17, 1, 'ZG-6482-TE', '2018-10-17 17:00:00', '2018-10-17 18:15:00'),
(18, 2, 'ZG-2186-AU', '2018-10-18 18:00:00', '2018-10-18 21:30:00'),
(19, 3, 'VU-7362-LJ', '2018-10-19 08:30:00', '2018-10-19 10:45:00'),
(20, 4, 'VT-1399-IN', '2018-10-20 09:30:00', '2018-10-20 12:00:00'),
(21, 5, 'VK-7634-CŠ', '2018-10-20 10:30:00', '2018-10-20 13:10:00'),
(22, 6, 'ŠI-2543-ČH', '2018-10-22 11:30:00', '2018-10-22 14:20:00'),
(23, 7, 'ST-166-ZJ', '2018-10-23 12:30:00', '2018-10-23 15:30:00'),
(24, 8, 'SL-4504-FŽ', '2018-10-24 13:30:00', '2018-10-24 16:40:00'),
(25, 1, 'VŽ-789-DS', '2018-10-25 14:30:00', '2018-10-25 17:50:00'),
(26, 5, 'VK-7634-CŠ', '2018-10-26 15:30:00', '2018-10-26 18:00:00'),
(27, 1, 'VŽ-789-DS', '2018-10-27 07:30:00', ''),
(28, 2, 'ZG-2186-AU', '2018-10-29 07:15:00', ''),
(29, 3, 'VU-7362-LJ', '2018-10-29 07:45:00', ''),
(30, 4, 'VT-1399-IN', '2018-10-30 07:00:00', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
