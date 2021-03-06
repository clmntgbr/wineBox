<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Media;
use App\Entity\User\User;
use App\Entity\Wine\Appellation;
use App\Entity\Wine\Bottle;
use App\Entity\Wine\Capacity;
use App\Entity\Wine\Color;
use App\Entity\Wine\Domain;
use App\Entity\Wine\Region;
use App\Entity\Wine\Wine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppFixtures extends Fixture implements ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    /** @var User */
    private $user;

    public function load(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');

        $user = new User();
        $user->setUsername('admin');

        $mail = "admin@gmail.com";
        $user->setEmail($mail);
        $user->setEnabled(true);
        $user->setRoles(["ROLE_ADMIN"]);
        $encodedPassword = $passwordEncoder->encodePassword($user, "admin");
        $user->setPassword($encodedPassword);

        $manager->persist($user);
        $manager->flush();

        $this->user = $user;

        $this->loadCapacity($manager);
        $this->loadColor($manager);
        $this->loadDomain($manager);
        $this->loadCountry($manager);
        $this->loadRegion($manager);
        $this->loadAppellation($manager);
        $this->loadWine($manager);
        $this->loadBottle($manager);
        $this->loadUser($manager);
    }

    private function loadUser(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername($i);
            $mail = "$i.com";
            $user->setEmail($mail);
            $user->setEnabled(true);
            $user->setRoles(["ROLE_USER"]);
            $encodedPassword = $passwordEncoder->encodePassword($user, "$i");
            $user->setPassword($encodedPassword);
            $this->addReference(sprintf('user-%s', $i), $user);

            $manager->persist($user);
            $manager->flush();
        }
    }

    private function loadWine(ObjectManager $manager)
    {
        for ($i = 0; $i < 200; $i++) {
            $entity = new Wine();
            $entity->setName(sprintf("Wine Name n°%s", $i));
            $entity->setDescription(sprintf("Wine Description n°%s", $i));
            $entity->setAppellation($this->getReference(sprintf("appellation-%s", rand(0,199))));
            $entity->setColor($this->getReference(sprintf("color-%s", rand(0,3))));
            $entity->setCapacity($this->getReference(sprintf("capacity-%s", rand(0,9))));
            $entity->setDomain($this->getReference(sprintf('domain-%s', rand(0,199))));
            $entity->setRegion($this->getReference(sprintf('region-%s', rand(0,199))));
            $media = new Media();
            $media->setName(sprintf("Name n°%s", $i));
            $media->setPath("/public/download/appellation/");
            $media->setMimeType("jpeg");
            $media->setType("appellation");
            $media->setSize(1000);
            $entity->setPreview($media);
            $entity->setCreatedBy($this->user);
            $manager->persist($entity);
            $this->addReference(sprintf('wine-%s', $i), $entity);
        }
        $manager->flush();
    }

    private function loadColor(ObjectManager $manager)
    {
        $description = ["", "", "", ""];
        $code = ['#f1f1f1', '#a71640', '#F6BBA1', '#FADF5E'];
        $name = [
            "Blanc",
            "Rouge",
            "Rosé",
            "Effervescent"
        ];

        for ($i = 0; $i < count($name); $i++) {
            $entity = new Color();
            $entity->setName($name[$i]);
            $entity->setDescription($description[$i]);
            $entity->setCssCode($code[$i]);
            $media = new Media();
            $media->setName(sprintf("Name n°%s", $i));
            $media->setPath("/public/download/appellation/");
            $media->setMimeType("jpeg");
            $media->setType("appellation");
            $media->setSize(1000);
            $entity->setPreview($media);
            $entity->setCreatedBy($this->user);
            $manager->persist($entity);
            $this->addReference("color-" . $i, $entity);
        }
        $manager->flush();
    }

    private function loadCapacity(ObjectManager $manager)
    {
        $description = ["75cl", "1L", "1,5L", "3L", "4,5L", "6L", "9L", "12L", "15L", "18L"];
        $value = ["75", "100", "150", "300", "450", "600", "900", "1200", "1500", "1800"];
        $name = [
            "Bouteille",
            "Litre",
            "Magnum",
            "Jéroboam",
            "Réhoboam",
            "Mathusalem",
            "Salmanazar",
            "Balthazar",
            "Nabuchodonosor",
            "Salomon"
        ];

        for ($i = 0; $i < count($name); $i++) {
            $entity = new Capacity();
            $entity->setName($name[$i]);
            $entity->setDescription($description[$i]);
            $entity->setValue($value[$i]);
            $media = new Media();
            $media->setName(sprintf("Name n°%s", $i));
            $media->setPath("/public/download/capacity/");
            $media->setMimeType("jpeg");
            $media->setType("capacity");
            $media->setSize(1000);
            $entity->setPreview($media);
            $entity->setCreatedBy($this->user);
            $manager->persist($entity);
            $this->addReference("capacity-" . $i, $entity);
        }
        $manager->flush();
    }

    private function loadDomain(ObjectManager $manager)
    {
        for ($i = 0; $i < 200; $i++) {
            $entity = new Domain();
            $entity->setName(sprintf("Domain Name n°%s", $i));
            $entity->setDescription(sprintf("Domain Description n°%s", $i));
            $media = new Media();
            $media->setName(sprintf("Name n°%s", $i));
            $media->setPath("/public/download/domain/");
            $media->setMimeType("jpeg");
            $media->setType("domain");
            $media->setSize(1000);
            $entity->setPreview($media);
            $entity->setCreatedBy($this->user);
            $manager->persist($entity);
            $this->addReference("domain-" . $i, $entity);
        }
        $manager->flush();
    }

    private function loadRegion(ObjectManager $manager)
    {
        for ($i = 0; $i < 200; $i++) {
            $entity = new Region();
            $entity->setName(sprintf("Region Name n°%s", $i));
            $entity->setDescription(sprintf("Region Description n°%s", $i));
            $entity->setCountry($this->getReference(sprintf('country-%s', rand(0,238))));
            $media = new Media();
            $media->setName(sprintf("Name n°%s", $i));
            $media->setPath("/public/download/region/");
            $media->setMimeType("jpeg");
            $media->setType("region");
            $media->setSize(1000);
            $entity->setPreview($media);
            $entity->setCreatedBy($this->user);
            $manager->persist($entity);
            $this->addReference("region-" . $i, $entity);
        }
        $manager->flush();
    }

    private function loadAppellation(ObjectManager $manager)
    {
        for ($i = 0; $i < 200; $i++) {
            $entity = new Appellation();
            $entity->setName(sprintf("Appellation Name n°%s", $i));
            $entity->setDescription(sprintf("Appellation Description n°%s", $i));
            $media = new Media();
            $media->setName(sprintf("Name n°%s", $i));
            $media->setPath("/public/download/appellation/");
            $media->setMimeType("jpeg");
            $media->setType("appellation");
            $media->setSize(1000);
            $entity->setPreview($media);
            $entity->setCreatedBy($this->user);
            $manager->persist($entity);
            $this->addReference("appellation-" . $i, $entity);
        }
        $manager->flush();
    }

    private function loadBottle(ObjectManager $manager)
    {
        $rand = rand(20, 100);

        for ($i = 0; $i < $rand; $i++) {
            $date = new \DateTime('now');
            $entity = new Bottle();
            $entity->setName(sprintf("Bottle Name n°%s", $i));
            $entity->setDescription(sprintf("Bottle Description n°%s", $i));
            $entity->setFamilyCode($i);
            $entity->setLocation(sprintf("%s%03d", 'A', $i));
            $entity->setApogeeAt($date->add(new \DateInterval(sprintf("P%sD", $i))));
            $entity->setAlertAt($date->add(new \DateInterval(sprintf("P%sD", $i*2))));
            $entity->setAlertComment(sprintf("Bottle Alert Comment n°%s", $i));
            $entity->setWine($this->getReference(sprintf('wine-%s', rand(0,199))));
            $entity->setBox($this->user->getBox());
            $entity->setCreatedBy($this->user);
            $media = new Media();
            $media->setName(sprintf("Name n°%s", $i));
            $media->setPath("/public/download/bottle/");
            $media->setMimeType("jpeg");
            $media->setType("bottle");
            $media->setSize(1000);
            $entity->setPreview($media);
            $manager->persist($entity);
        }

        $rand = rand(500, 1000);


        for ($i = 0; $i < $rand; $i++) {
            $date = (new \DateTime('now'))->sub(new \DateInterval(sprintf("P%sD", $rand)));
            $entity = new Bottle();
            $entity->setName(sprintf("Bottle Name n°%s", $i));
            $entity->setDescription(sprintf("Bottle Description n°%s", $i));
            $entity->setFamilyCode($i);
            $entity->setLocation(null);
            $entity->setStatus(Bottle::STATUS_EMPTY);
            $entity->setEmptyAt($date->add(new \DateInterval(sprintf("P%sD", $i))));
            $entity->setWine($this->getReference(sprintf('wine-%s', rand(0,199))));
            $entity->setBox($this->user->getBox());
            $entity->setCreatedBy($this->user);
            $media = new Media();
            $media->setName(sprintf("Name n°%s", $i));
            $media->setPath("/public/download/bottle/");
            $media->setMimeType("jpeg");
            $media->setType("bottle");
            $media->setSize(1000);
            $entity->setPreview($media);
            $manager->persist($entity);
        }

        $manager->flush();
    }

    private function loadCountry(ObjectManager $manager)
    {
        $name = [
            "Abbaye de Montserrat",
            "Afghanistan",
            "Afrique du Sud",
            "Åland",
            "Albanie",
            "Algérie",
            "Allemagne",
            "Andorre",
            "Angola",
            "Anguilla",
            "Antigue et Barbude",
            "Antilles néerlandaises",
            "Arabie saoudite",
            "Argentine",
            "Armenie",
            "Aruba",
            "Australie",
            "Austriche",
            "Azerbaïdjan",
            "Bahamas",
            "Bahreïn",
            "Bangladesh",
            "Barbade",
            "Belgique",
            "Belize",
            "Benin",
            "Bermudes",
            "Bhutan",
            "Biélorussie",
            "Birmanie",
            "Bolivie",
            "Bosnie",
            "Botswana",
            "Brésil",
            "Brunei",
            "Bulgarie",
            "Burkina Faso",
            "Burundi",
            "Cambodge",
            "Cameroun",
            "Canada",
            "Cap Vert",
            "Chili",
            "Chine",
            "Chypre",
            "Colombie",
            "Comores",
            "Congo",
            "Corée du Nord",
            "Corée du Sud",
            "Costa Rica",
            "Cote D'Ivoire",
            "Croatie",
            "Cuba",
            "Danemark",
            "Djibouti",
            "Dominique",
            "Egypte",
            "Équateur",
            "Érythrée",
            "Espagne",
            "Estonie",
            "États-Unis",
            "Éthiopie",
            "Fidji",
            "Finlande",
            "France",
            "France d'outre-mer",
            "Gabon",
            "Gambie",
            "Georgie",
            "Ghana",
            "Gibraltar",
            "Grèce",
            "Grenade",
            "Groenland",
            "Guadeloupe",
            "Guam",
            "Guatemala",
            "Guinée",
            "Guinée Bissau",
            "Guinée équatoriale",
            "Guyana",
            "Guyane",
            "Haïti",
            "Honduras",
            "Hong Kong",
            "Hongrie",
            "Île Bouvet",
            "Île Christmas",
            "Île Jan Mayen",
            "Île Norfolk",
            "Îles Caïmans",
            "Îles Cocos",
            "Îles Cook",
            "Îles Féroé",
            "Îles Heard et MacDonald",
            "Îles Malouines",
            "Îles Mariannes du Nord",
            "Îles Marshall",
            "Îles mineures éloignées des États-Unis",
            "Îles Pitcairn",
            "Îles Salomon",
            "îles Sandwich Hawaï",
            "Îles Turks-et-Caïcos",
            "Îles Vierges britanniques",
            "Îles Vierges des États-Unis",
            "Inde",
            "Indonésie",
            "Irak",
            "Iran",
            "Irlande",
            "Islande",
            "Israël",
            "Italie",
            "Jamaïque",
            "Japon",
            "Jordanie",
            "Kazakhstan",
            "Kenya",
            "Kirghizistan",
            "Kiribati",
            "Koweït",
            "Laos",
            "Lesotho",
            "Lettonie",
            "Liban",
            "Liberia",
            "Libye",
            "Liechtenstein",
            "Lithuanie",
            "Luxembourg",
            "Macao",
            "Macédoine",
            "Madagascar",
            "Malaisie",
            "Malawi",
            "Maldives",
            "Mali",
            "Malte",
            "Maroc",
            "Martinique",
            "Maurice",
            "Mauritanie",
            "Mayotte",
            "Mexique",
            "Micronésie",
            "Moldavie",
            "Monaco",
            "Mongolie",
            "Monténégro",
            "Mozambique",
            "Namibie",
            "Nauru",
            "Népal",
            "Nicaragua",
            "Niger",
            "Nigeria",
            "Niue",
            "Norvège",
            "Nouvelle Calédonie",
            "Nouvelle-Zélande",
            "Oman",
            "Ouganda",
            "Ouzbékistan",
            "Pakistan",
            "Palaos",
            "Palestine",
            "Panama",
            "Papouasie-Nouvelle-Guinée",
            "Paraguay",
            "Pays-Bas",
            "Pérou",
            "Philippines",
            "Pologne",
            "Polynésie française",
            "Porto Rico",
            "Portugal",
            "Qatar",
            "République centrafricaine",
            "République dominicaine",
            "République du Congo",
            "République tchèque",
            "Réunion",
            "Roumanie",
            "Royaume-Uni",
            "Russie",
            "Rwanda",
            "Sahara occidental",
            "Saint Christophe et Niévès",
            "Saint-Marin",
            "Saint-Pierre-et-Miquelon",
            "Saint-Vincent-et-les-Grenadines",
            "Sainte Lucie",
            "Sainte-Hélène",
            "Salvador",
            "Samoa",
            "Samoa américaines",
            "Sao Tomé-et-Principe",
            "Sénégal",
            "Serbie",
            "Seychelles",
            "Sierra Leone",
            "Singapour",
            "Slovaquie",
            "Slovénie",
            "Somalie",
            "Soudan",
            "Sri Lanka",
            "Suède",
            "Suisse",
            "Suriname",
            "Swaziland",
            "Syrie",
            "Tadjikistan",
            "Taiwan",
            "Tanzanie",
            "Tchad",
            "Territoire britannique de l'océan Indien",
            "Thaïlande",
            "Timor oriental",
            "Togo",
            "Tokelau",
            "Tonga",
            "Trinité-et-Tobago",
            "Tunisie",
            "Turkménistan",
            "Turquie",
            "Tuvalu",
            "Ukraine",
            "Uruguay",
            "Vanuatu",
            "Vatican",
            "Venezuela",
            "Vietnam",
            "Wallis-et-Futuna",
            "Yémen",
            "Zambie",
            "Zimbabwe"
        ];
        $flag = [
            "ms",
            "af",
            "za",
            "ax",
            "al",
            "dz",
            "de",
            "ad",
            "ao",
            "ai",
            "ag",
            "an",
            "sa",
            "ar",
            "am",
            "aw",
            "au",
            "at",
            "az",
            "bs",
            "bh",
            "bd",
            "bb",
            "be",
            "bz",
            "bj",
            "bm",
            "bt",
            "by",
            "mm",
            "bo",
            "ba",
            "bw",
            "br",
            "bn",
            "bg",
            "bf",
            "bi",
            "kh",
            "cm",
            "ca",
            "cv",
            "cl",
            "cn",
            "cy",
            "co",
            "km",
            "cd",
            "kp",
            "kr",
            "cr",
            "ci",
            "hr",
            "cu",
            "dk",
            "dj",
            "dm",
            "eg",
            "ec",
            "er",
            "es",
            "ee",
            "us",
            "et",
            "fj",
            "fi",
            "fr",
            "tf",
            "ga",
            "gm",
            "ge",
            "gh",
            "gi",
            "gr",
            "gd",
            "gl",
            "gp",
            "gu",
            "gt",
            "gn",
            "gw",
            "gq",
            "gy",
            "gf",
            "ht",
            "hn",
            "hk",
            "hu",
            "bv",
            "cx",
            "sj",
            "nf",
            "ky",
            "cc",
            "ck",
            "fo",
            "hm",
            "fk",
            "mp",
            "mh",
            "um",
            "pn",
            "sb",
            "gs",
            "tc",
            "vg",
            "vi",
            "in",
            "id",
            "iq",
            "ir",
            "ie",
            "is",
            "il",
            "it",
            "jm",
            "jp",
            "jo",
            "kz",
            "ke",
            "kg",
            "ki",
            "kw",
            "la",
            "ls",
            "lv",
            "lb",
            "lr",
            "ly",
            "li",
            "lt",
            "lu",
            "mo",
            "mk",
            "mg",
            "my",
            "mw",
            "mv",
            "ml",
            "mt",
            "ma",
            "mq",
            "mu",
            "mr",
            "yt",
            "mx",
            "fm",
            "md",
            "mc",
            "mn",
            "me",
            "mz",
            "na",
            "nr",
            "np",
            "ni",
            "ne",
            "ng",
            "nu",
            "no",
            "nc",
            "nz",
            "om",
            "ug",
            "uz",
            "pk",
            "pw",
            "ps",
            "pa",
            "pg",
            "py",
            "nl",
            "pe",
            "ph",
            "pl",
            "pf",
            "pr",
            "pt",
            "qa",
            "cf",
            "do",
            "cg",
            "cz",
            "re",
            "ro",
            "gb",
            "ru",
            "rw",
            "eh",
            "kn",
            "sm",
            "pm",
            "vc",
            "lc",
            "sh",
            "sv",
            "ws",
            "as",
            "st",
            "sn",
            "rs",
            "sc",
            "sl",
            "sg",
            "sk",
            "si",
            "so",
            "sd",
            "lk",
            "se",
            "ch",
            "sr",
            "sz",
            "sy",
            "tj",
            "tw",
            "tz",
            "td",
            "io",
            "th",
            "tl",
            "tg",
            "tk",
            "to",
            "tt",
            "tn",
            "tm",
            "tr",
            "tv",
            "ua",
            "uy",
            "vu",
            "va",
            "ve",
            "vn",
            "wf",
            "ye",
            "zm",
            "zw"
        ];
        $iso2 = [
            "MS",
            "AF",
            "ZA",
            "AX",
            "AL",
            "DZ",
            "DE",
            "AD",
            "AO",
            "AI",
            "AG",
            "AN",
            "SA",
            "AR",
            "AM",
            "AW",
            "AU",
            "AT",
            "AZ",
            "BS",
            "BH",
            "BD",
            "BB",
            "BE",
            "BZ",
            "BJ",
            "BM",
            "BT",
            "BY",
            "MM",
            "BO",
            "BA",
            "BW",
            "BR",
            "BN",
            "BG",
            "BF",
            "BI",
            "KH",
            "CM",
            "CA",
            "CV",
            "CL",
            "CN",
            "CY",
            "CO",
            "KM",
            "CD",
            "KP",
            "KR",
            "CR",
            "CI",
            "HR",
            "CU",
            "DK",
            "DJ",
            "DM",
            "EG",
            "EC",
            "ER",
            "ES",
            "EE",
            "US",
            "ET",
            "FJ",
            "FI",
            "FR",
            "TF",
            "GA",
            "GM",
            "GE",
            "GH",
            "GI",
            "GR",
            "GD",
            "GL",
            "GP",
            "GU",
            "GT",
            "GN",
            "GW",
            "GQ",
            "GY",
            "GF",
            "HT",
            "HN",
            "HK",
            "HU",
            "BV",
            "CX",
            "SJ",
            "NF",
            "KY",
            "CC",
            "CK",
            "FO",
            "HM",
            "FK",
            "MP",
            "MH",
            "UM",
            "PN",
            "SB",
            "GS",
            "TC",
            "VG",
            "VI",
            "IN",
            "ID",
            "IQ",
            "IR",
            "IE",
            "IS",
            "IL",
            "IT",
            "JM",
            "JP",
            "JO",
            "KZ",
            "KE",
            "KG",
            "KI",
            "KW",
            "LA",
            "LS",
            "LV",
            "LB",
            "LR",
            "LY",
            "LI",
            "LT",
            "LU",
            "MO",
            "MK",
            "MG",
            "MY",
            "MW",
            "MV",
            "ML",
            "MT",
            "MA",
            "MQ",
            "MU",
            "MR",
            "YT",
            "MX",
            "FM",
            "MD",
            "MC",
            "MN",
            "ME",
            "MZ",
            "NA",
            "NR",
            "NP",
            "NI",
            "NE",
            "NG",
            "NU",
            "NO",
            "NC",
            "NZ",
            "OM",
            "UG",
            "UZ",
            "PK",
            "PW",
            "PS",
            "PA",
            "PG",
            "PY",
            "NL",
            "PE",
            "PH",
            "PL",
            "PF",
            "PR",
            "PT",
            "QA",
            "CF",
            "DO",
            "CG",
            "CZ",
            "RE",
            "RO",
            "GB",
            "RU",
            "RW",
            "EH",
            "KN",
            "SM",
            "PM",
            "VC",
            "LC",
            "SH",
            "SV",
            "WS",
            "AS",
            "ST",
            "SN",
            "RS",
            "SC",
            "SL",
            "SG",
            "SK",
            "SI",
            "SO",
            "SD",
            "LK",
            "SE",
            "CH",
            "SR",
            "SZ",
            "SY",
            "TJ",
            "TW",
            "TZ",
            "TD",
            "IO",
            "TH",
            "TL",
            "TG",
            "TK",
            "TO",
            "TT",
            "TN",
            "TM",
            "TR",
            "TV",
            "UA",
            "UY",
            "VU",
            "VA",
            "VE",
            "VN",
            "WF",
            "YE",
            "ZM",
            "ZW"
        ];
        $iso3 = [
            "MSR",
            "AFG",
            "ZAF",
            "ALA",
            "ALB",
            "DZA",
            "DEU",
            "AND",
            "AGO",
            "AIA",
            "ATG",
            "ANT",
            "SAU",
            "ARG",
            "ARM",
            "ABW",
            "AUS",
            "AUT",
            "AZE",
            "BHS",
            "BHR",
            "BGD",
            "BRB",
            "BEL",
            "BLZ",
            "BEN",
            "BMU",
            "BTN",
            "BLR",
            "MMR",
            "BOL",
            "BIH",
            "BWA",
            "BRA",
            "BRN",
            "BGR",
            "BFA",
            "BDI",
            "KHM",
            "CMR",
            "CAN",
            "CPV",
            "CHL",
            "CHN",
            "CYP",
            "COL",
            "COM",
            "COD",
            "PRK",
            "KOR",
            "CRI",
            "CIV",
            "HRV",
            "CUB",
            "DNK",
            "DJI",
            "DMA",
            "EGY",
            "ECU",
            "ERI",
            "ESP",
            "EST",
            "USA",
            "ETH",
            "FJI",
            "FIN",
            "FRA",
            "ATF",
            "GAB",
            "GMB",
            "GEO",
            "GHA",
            "GIB",
            "GRC",
            "GRD",
            "GRL",
            "GLP",
            "GUM",
            "GTM",
            "GIN",
            "GNB",
            "GNQ",
            "GUY",
            "GUF",
            "HTI",
            "HND",
            "HKG",
            "HUN",
            "BVT",
            "CXR",
            "SJM",
            "NFK",
            "CYM",
            "CCK",
            "COK",
            "FRO",
            "HMD",
            "FLK",
            "MNP",
            "MHL",
            "UMI",
            "PCN",
            "SLB",
            "SGS",
            "TCA",
            "VGB",
            "VIR",
            "IND",
            "IDN",
            "IRQ",
            "IRN",
            "IRL",
            "ISL",
            "ISR",
            "ITA",
            "JAM",
            "JPN",
            "JOR",
            "KAZ",
            "KEN",
            "KGZ",
            "KIR",
            "KWT",
            "LAO",
            "LSO",
            "LVA",
            "LBN",
            "LBR",
            "LBY",
            "LIE",
            "LTU",
            "LUX",
            "MAC",
            "MKD",
            "MDG",
            "MYS",
            "MWI",
            "MDV",
            "MLI",
            "MLT",
            "MAR",
            "MTQ",
            "MUS",
            "MRT",
            "MYT",
            "MEX",
            "FSM",
            "MDA",
            "MCO",
            "MNG",
            "MNE",
            "MOZ",
            "NAM",
            "NRU",
            "NPL",
            "NIC",
            "NER",
            "NGA",
            "NIU",
            "NOR",
            "NCL",
            "NZL",
            "OMN",
            "UGA",
            "UZB",
            "PAK",
            "PLW",
            "PSE",
            "PAN",
            "PNG",
            "PRY",
            "NLD",
            "PER",
            "PHL",
            "POL",
            "PYF",
            "PRI",
            "PRT",
            "QAT",
            "CAF",
            "DOM",
            "COG",
            "CZE",
            "REU",
            "ROU",
            "GBR",
            "RUS",
            "RWA",
            "ESH",
            "KNA",
            "SMR",
            "SPM",
            "VCT",
            "LCA",
            "SHN",
            "SLV",
            "WSM",
            "ASM",
            "STP",
            "SEN",
            "SRB",
            "SYC",
            "SLE",
            "SGP",
            "SVK",
            "SVN",
            "SOM",
            "SDN",
            "LKA",
            "SWE",
            "CHE",
            "SUR",
            "SWZ",
            "SYR",
            "TJK",
            "TWN",
            "TZA",
            "TCD",
            "IOT",
            "THA",
            "TLS",
            "TGO",
            "TKL",
            "TON",
            "TTO",
            "TUN",
            "TKM",
            "TUR",
            "TUV",
            "UKR",
            "URY",
            "VUT",
            "VAT",
            "VEN",
            "VNM",
            "WLF",
            "YEM",
            "ZMB",
            "ZWE"
        ];
        $isoNumeric = [
            "500",
            "004",
            "710",
            "248",
            "008",
            "012",
            "276",
            "020",
            "024",
            "660",
            "028",
            "530",
            "682",
            "032",
            "051",
            "533",
            "036",
            "040",
            "031",
            "044",
            "048",
            "050",
            "052",
            "056",
            "084",
            "204",
            "060",
            "064",
            "112",
            "104",
            "068",
            "070",
            "072",
            "076",
            "096",
            "100",
            "854",
            "108",
            "116",
            "120",
            "124",
            "132",
            "152",
            "156",
            "196",
            "170",
            "174",
            "180",
            "408",
            "410",
            "188",
            "384",
            "191",
            "192",
            "208",
            "262",
            "212",
            "818",
            "218",
            "232",
            "724",
            "233",
            "840",
            "231",
            "242",
            "246",
            "250",
            "260",
            "266",
            "270",
            "268",
            "288",
            "292",
            "300",
            "308",
            "304",
            "312",
            "316",
            "320",
            "324",
            "624",
            "226",
            "328",
            "254",
            "332",
            "340",
            "344",
            "348",
            "074",
            "162",
            "744",
            "574",
            "136",
            "166",
            "184",
            "234",
            "334",
            "238",
            "580",
            "584",
            "581",
            "612",
            "090",
            "239",
            "796",
            "092",
            "850",
            "356",
            "360",
            "368",
            "364",
            "372",
            "352",
            "376",
            "380",
            "388",
            "392",
            "400",
            "398",
            "404",
            "417",
            "296",
            "414",
            "418",
            "426",
            "428",
            "422",
            "430",
            "434",
            "438",
            "440",
            "442",
            "446",
            "807",
            "450",
            "458",
            "454",
            "462",
            "466",
            "470",
            "504",
            "474",
            "480",
            "478",
            "175",
            "484",
            "583",
            "498",
            "492",
            "496",
            "499",
            "508",
            "516",
            "520",
            "524",
            "558",
            "562",
            "566",
            "570",
            "578",
            "540",
            "554",
            "512",
            "800",
            "860",
            "586",
            "585",
            "275",
            "591",
            "598",
            "600",
            "528",
            "604",
            "608",
            "616",
            "258",
            "630",
            "620",
            "634",
            "140",
            "214",
            "178",
            "203",
            "638",
            "642",
            "826",
            "643",
            "646",
            "732",
            "659",
            "674",
            "666",
            "670",
            "662",
            "654",
            "222",
            "882",
            "016",
            "678",
            "686",
            "688",
            "690",
            "694",
            "702",
            "703",
            "705",
            "706",
            "736",
            "144",
            "752",
            "756",
            "740",
            "748",
            "760",
            "762",
            "158",
            "834",
            "148",
            "086",
            "764",
            "626",
            "768",
            "772",
            "776",
            "780",
            "788",
            "795",
            "792",
            "798",
            "804",
            "858",
            "548",
            "336",
            "862",
            "704",
            "876",
            "887",
            "894",
            "716"
        ];

        for ($i = 0; $i < count($name); $i++) {
            $country = new Country();
            $country->setName($name[$i]);
            $country->setFlag($flag[$i]);
            $country->setIso2($iso2[$i]);
            $country->setIso3($iso3[$i]);
            $country->setIsoNumeric($isoNumeric[$i]);
            $manager->persist($country);
            $this->addReference('country-'.$i, $country);
        }
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}