-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 11 2017 г., 09:43
-- Версия сервера: 10.1.10-MariaDB
-- Версия PHP: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `sciencegrid`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Analysis'),
(2, 'Communication'),
(3, 'Data'),
(4, 'Hypothesis'),
(5, 'Instrumentation'),
(6, 'Methods and Measures'),
(7, 'Procedure'),
(8, 'Project'),
(9, 'Software'),
(10, 'Other'),
(11, 'Uncategorized');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(125, '2014_10_12_000000_create_users_table', 1),
(126, '2014_10_12_100000_create_password_resets_table', 1),
(127, '2017_03_13_115833_create_projects_table', 1),
(128, '2017_03_15_100953_create_allows_table', 1),
(136, '2017_03_28_090702_create_tags_table', 2),
(137, '2017_03_28_091814_create_p_and_tags_table', 2),
(138, '2017_03_29_113141_create_categories_table', 2),
(139, '2017_04_05_200051_create_education_table', 2),
(140, '2017_04_05_200105_create_employments_table', 2),
(141, '2017_04_06_141422_create_user_and_educations_table', 2),
(142, '2017_04_06_141449_create_user_and_employments_table', 2),
(143, '2017_04_14_152409_create_project_and_files_table', 2),
(171, '2017_03_15_100953_create_project_and_contributors_table', 3),
(172, '2017_03_28_091814_create_project_and_tags_table', 3),
(173, '2017_04_14_154015_create_project_and_files_table', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` int(11) NOT NULL,
  `privacyLevel` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'private',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `category`, `privacyLevel`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Open Science Collaboration', 'An open collaboration of scientists to increase the alignment between scientific values and scientific practices.', 1, NULL, '2017-04-06 10:25:19', '2017-04-06 10:25:19', 1),
(2, 'Preservation of Corporate Information Public   1 Share\n', 'Considering preservation before there is a need for preservation may be the next wave of corporate interest. While corporate interests often have to do with keeping up with Jones Co, preservation, I hope, will not suffer the same fate as other fads. Preservation of corporate information has multiple challenges: legal, real estate, bottom-line and out of date equipment required to access superseded formats. It does, however, also offer an element of content management that can be a boon to the bottom-line. This discussion will identify some of the problems faced by corporate information professionals in terms of preservation and access as well as some of the solutions available. We will also talk about succession planning, the value of trained information professionals working on preservation in for profit environments and how academics, by having a better understanding of corporate problems, can help develop tools and techniques to mitigate some of these problems.', 1, NULL, '2017-04-06 10:50:08', '2017-04-06 10:50:08', 1),
(4, 'Open Science: What, Why, and How Public   1 Share\n', 'Open Science is a collection of actions designed to make scientific processes more transparent and results more accessible. Its goal is to build a more replicable and robust science; it does so using new technologies, altering incentives, and changing attitudes. The current movement towards open science was spurred, in part, by a recent “series of unfortunate events” within psychology and other sciences. These events include the large number of studies that have failed to replicate and the prevalence of common research and publication procedures that could explain why. Many journals and funding agencies now encourage, require, or reward some open science practices, including pre-registration, providing full materials, posting data, distinguishing between exploratory and confirmatory analyses, and running replication studies. Individuals can practice and encourage open science in their many roles as researchers, authors, reviewers, editors, teachers, and members of hiring, tenure, promotion, and awards committees. A plethora of resources are available to help scientists, and science, achieve these goals.', 1, NULL, '2017-04-07 11:20:31', '2017-04-07 11:20:31', 2),
(5, 'State anxiety and emotional face recognition in healthy volunteers', 'High trait anxiety has been associated with detriments in emotional face processing. In contrast, relatively little is known about the effects of state anxiety on emotional face processing. We investigated the effects of state anxiety on recognition of emotional expressions (anger, sadness, surprise, disgust, fear, happiness) experimentally, using the 7.5% carbon dioxide (CO2) model to induce state anxiety, and in a large online study. The experimental studies indicated reduced global (rather than emotion-specific) emotion recognition accuracy and increased interpretation bias (a tendency to perceive anger) when state anxiety was heightened. The online study confirmed that higher state anxiety is associated with poorer emotion recognition, and indicated that negative effects of trait anxiety are negated when controlling for state anxiety, suggesting a mediating effect of state anxiety. These findings have implications for anxiety disorders, which are characterised by increased frequency, intensity or duration of state anxious episodes.', 1, NULL, '2017-04-08 16:27:22', '2017-04-08 16:27:22', 1),
(32, 'Musicians have a better memory than nonmusicians: a meta-analysis', 'Several researchers investigated whether musicians (i.e., people who underwent a long music training) have better performances than nonmusicians (i.e., people who received little to no music training) in memory tasks. Although results suggest an advantage of musicians over nonmusicians in various tasks, some studies did not observe this advantage. For this reason, we ran a meta-analysis with the aim of understanding whether there is any positive effect of the music training on memory in young adults. We collected 29 studies that included 53 different tasks. Tasks were divided in three categories, depending on the system of memory tapped: long-term memory, short-term memory, and working memory. Three meta-analyses were conducted separately for each memory system. We also tested the effect of a possible moderator that we defined as the type of stimuli (i.e., verbal, visuospatial, and tonal) used in the study. The three meta-analyses revealed a medium effect-size (i.e., a musicians’ advantage) in short-term memory and in working memory suggesting that the music training benefits these two memory systems. Moreover, there was an effect of the moderator, suggesting that the type of stimuli modulates the results. In short term memory and working memory the advantage of musicians was large with tonal stimuli, moderate with verbal stimuli and small to null for visuospatial ones. In contrast, in long-term memory the effect-size was small, with no effect of the moderator.', 1, NULL, '2017-04-12 12:38:00', '2017-04-12 12:38:00', 1),
(33, 'Diamond Plots: a tutorial to introduce a visualisation tool that facilitates interpretation and comparison of multiple sample estimates while respecting their inaccuracy', 'Although a shift from a focus on null hypothesis significance testing to reporting effect sizes and confidence intervals has been advocated for decades, researchers have been slow to implement this shift. One of the reasons may be that working with confidence intervals is interpreted as inconvenient. Diamond plots are a visualisation technique to ameliorate this disadvantage. The current paper introduces an implementation of diamond plots in the free and open source software R. This implementation is flexible and designed to also be accessible to researchers that are not used to working with R. The current paper also includes a tutorial to enable researchers to start producing diamond plots themselves with minimal effort. Combining a shift from reporting point estimates and confidence intervals in tables to using diamond plots with full disclosure enables presenting reports in a readable manner without loss of detail.', 1, NULL, '2017-04-14 09:32:50', '2017-04-14 09:32:50', 2),
(34, 'How to Read a Journal Article - An Open Access Guide', 'A guide to reading academic journal articles', 1, NULL, '2017-04-14 09:33:45', '2017-04-14 09:33:45', 2),
(35, 'Logical and methodological issues affecting neurogenetic studies of humans', 'Genetics and neuroscience are two areas of science that pose particular methodological problems because they involve detecting weak signals (i.e., small effects) in noisy data. In recent years, increasing numbers of studies have attempted to bridge these disciplines by looking for genetic factors associated with individual differences in behaviour, cognition and brain structure or function. However, different methodological approaches to guarding against false positives have evolved in the two disciplines. To explore methodological issues affecting neurogenetic studies, we conducted an in-depth analysis of 30 consecutive articles in 12 top neuroscience journals that reported on genetic associations in non-clinical human samples. It was often difficult to estimate effect sizes in neuroimaging paradigms. Where effect sizes could be calculated, the studies reporting the largest effect sizes tended to have two features: (i) they had the smallest samples, and were generally underpowered to detect genetic effects; and (ii) they did not fully correct for multiple comparisons. Furthermore, only a minority of studies used statistical methods for multiple comparisons that took into account correlations between phenotypes or genotypes, and only nine studies included a replication sample, or replicated a prior finding. Finally, presentation of methodological information was not standardized and was often distributed across Methods sections and Supplementary Material, making it challenging to assemble basic information from many studies. Space limits imposed by journals could mean that highly complex statistical methods were described in only a superficial fashion. In sum, methods which have become standard in the genetics literature – stringent statistical standards, use of large samples and replication of findings – are not always adopted when behavioural, cognitive or neuroimaging phenotypes are used, leading to an increased risk of false positive findings. Studies need to correct not just for the number of phenotypes collected, but also for number of genotypes examined, genetic models tested and subsamples investigated. The field would benefit from more widespread use of methods that take into account correlations between the factors corrected for, such as spectral decomposition, or permutation approaches. Replication should become standard practice; this, together with the need for larger sample sizes, will entail greater emphasis on collaboration between research groups. We conclude with some specific suggestions for standardized reporting in this area.', 1, NULL, '2017-04-14 09:34:11', '2017-04-14 09:34:11', 2),
(36, 'Collaborative Replications and Education Project (CREP)', 'This is a replication project where students are encouraged to conduct replications as part of their courses.', 1, NULL, '2017-04-14 09:34:26', '2017-04-14 09:34:26', 2),
(37, 'Tracing Contours of Collaborative Digital Pedagogy', 'This snapshot presentation reports on research in progress. Our study seeks to understand the contours of pedagogical partnerships between scholars in different roles in the university—namely, between librarians and disciplinary faculty members. We are particularly interested in partnerships to perform instruction focused on digital scholarship. We hope that the outcome of our research will be to characterize models for collaborative digital scholarship pedagogy that create powerful learning experiences for students and that librarians and disciplinary faculty members find mutually rewarding.', 1, NULL, '2017-04-14 09:34:32', '2017-04-14 09:34:32', 2),
(38, 'Algorithmic Accountability', 'Accountability is fundamentally about checks and balances to power. In theory, both government and corporations are kept accountable through social, economic, and political mechanisms. Journalism and public advocates serve as an additional tool to hold powerful institutions and individuals accountable. But in a world of data and algorithms, accountability is often murky. Beyond questions about whether the market is sufficient or governmental regulation is necessary, how should algorithms be held accountable? For example what is the role of the fourth estate in holding data-oriented practices accountable?', 1, NULL, '2017-04-14 09:34:42', '2017-04-14 09:34:42', 2),
(39, 'Algorithmic Manifolds and Their Properties', 'About computational complexity, it has been studied for long time. Recent literature has shown that the existing proof method using the diagonal argument or the circuit complexity is not effective. On the other hand, as another approach, calculation of time complexity based on the geometric method is also performed, but it is limited to the quantum algorithm, and it is an application example to the existing method of lower band derivation of quantum circuit complexity, it is essentially unchanged.\n　In this paper, I introduce algorithmic manifolds that explain algorithms by geometric methods and discuss their properties. In the section 2, I discuss the relationship between algorithmic manifolds and time. In the section 3, I discuss the relationship between algorithmic manifolds and amounts of data. In the section 4, I discuss topological characteristics of algorithmic manifolds. The section 5 is the conclusion of this paper.', 1, NULL, '2017-04-14 09:34:56', '2017-04-14 09:34:56', 2),
(40, 'From One to Many: Synced Hash-Based Signatures', 'Hash-based signatures use a one-time signature (OTS) as its main building block, and transform it into a many-times scheme, to sign a larger number of signatures. In known constructions, the cost and the size of each signature increase as the number of needed signatures grows. In real-world applications, requiring a significant number of signatures, the signatures can get quite large. As a result, it is usually believed that post-quantum signatures based on hashes need more computation and much larger sizes than classical signatures. We introduce a construction to challenge that idea: we show that it is possible to construct a many-times signatures scheme that is more efficient than the OTS it is built from, rather than less.\nWe study the generation of signatures in conjunction with a blockchain, like bitcoin. The proposed scheme permits an unlimited number of signatures. The size of each signatures is constant and the same as in the OTS. The verification cost starts the same as in the OTS and decreases with each new signature, becoming more efficient on average as the number of signatures grows.', 1, NULL, '2017-04-14 10:11:24', '2017-04-14 10:11:24', 2),
(41, 'Unpacking Blockchains', 'The Bitcoin digital currency appeared in 2009. Since this time, researchers and practitioners have looked “under the hood” of the open source Bitcoin currency, and discovered that Bitcoin’s “Blockchain” software architecture is useful for non-monetary purposes too. By coalescing the research and practice on Blockchains, this work begins to unpack Blockchains as a general phenomenon, therein, arguing that all Blockchain phenomena can be conceived as being comprised of transaction platforms and digital ledgers, and illustrating where public key encryption plays a differential role in facilitating these features of Blockchains.', 1, NULL, '2017-04-14 10:12:31', '2017-04-14 10:12:31', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `project_and_contributors`
--

CREATE TABLE `project_and_contributors` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permissions` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `project_and_files`
--

CREATE TABLE `project_and_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `project_and_stakeholders`
--

CREATE TABLE `project_and_stakeholders` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `stakeholder_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `project_and_tags`
--

CREATE TABLE `project_and_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `project_and_theircontributors`
--

CREATE TABLE `project_and_theircontributors` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `project_and_theircontributors`
--

INSERT INTO `project_and_theircontributors` (`id`, `project_id`, `user_id`, `permission`) VALUES
(1, 32, 2, 'Read'),
(2, 32, 3, 'Read'),
(3, 32, 4, 'Read+Write'),
(4, 2, 3, 'Read'),
(6, 2, 2, 'Read+Write'),
(9, 1, 4, 'Read+Write'),
(14, 4, 1, 'Read'),
(15, 4, 3, 'Read'),
(16, 5, 4, 'Read'),
(17, 5, 3, 'Read+Write');

-- --------------------------------------------------------

--
-- Структура таблицы `stakeholders`
--

CREATE TABLE `stakeholders` (
  `id` int(10) UNSIGNED NOT NULL,
  `stakeholderName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `fullName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `fullName`, `email`, `password`, `address`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Darkhan Mukatay', 'mukatay@gmail.com', '$2y$10$Y.uCD.ZiZc2JIQMWIwi15uileCidETV6AMdsyR3ytW1nh/5Fb0icm', NULL, 'admin', 'FpUF1eTfhL4D2Mh3cOTCmH8ih9bFOEYgypVhn4FDVHZ1bYXQjXuFDljld8UL', '2017-04-06 08:42:01', '2017-04-06 09:29:12'),
(2, 'Olzhas Aitbekov', 'aitbekov@gmail.com', '$2y$10$PDCmWJ4mmXVrkz7GnRgy8eTmx.pnlEK6ySiDeiu3iLg.yX0n9hn12', NULL, 'user', 'QXcOO7RJN7e9w4dtMIuhcUIGp3JrzUtVMtGkYvKiEuWvjS41F2inVCAGPeXM', '2017-04-07 11:20:18', '2017-04-07 11:20:18'),
(3, 'Sakypkerey Ramazan', 'sakypkerey@gmail.com', '$2y$10$H6bz5UDlKm8OX7bAg/tYguaJCxEhqvQ9L3Vl3CzeGYBKMrXCLW46u', NULL, 'user', 'c2JRj57DXq1tRFF1ptBr1BIe8h0fr5cSnWpMCQA3cQpLjrGBEt2tmDUDRhfV', '2017-04-07 11:52:39', '2017-04-07 11:52:39'),
(4, 'Nurzhan Duzbayev', 'duzbayev@gmail.com', '$2y$10$0iSgTg3/2QEXZjvepZpDR.l2zn2LkdTLxt07PXKUiNtnAK16mvBYG', NULL, 'admin', 'DziZ6ZeOLLvvs1BbhsBTx5DVbXt7Kfh0cN2UH0lqXeaedKXFgk9b10OSYNfi', '2017-04-11 09:41:41', '2017-04-11 09:41:41'),
(5, 'Jack Wilshere', 'jackwilshere@gmail.com', '$2y$10$mrgoW/TZqusRsyMbGXZD5uPs5yvMoqpPTXuXyWN7TDWoCIdM6Wwlq', NULL, 'user', 'S6yGFHwjXSfSCPgJLA8lusbjnRPY62UEjtdFzLtTYijLDEvaLO4d8aXe6aDB', '2017-05-11 06:45:02', '2017-05-11 06:45:02');

-- --------------------------------------------------------

--
-- Структура таблицы `user_and_educations`
--

CREATE TABLE `user_and_educations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `education_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_and_employments`
--

CREATE TABLE `user_and_employments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `employment_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Индексы таблицы `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `project_and_contributors`
--
ALTER TABLE `project_and_contributors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `project_and_files`
--
ALTER TABLE `project_and_files`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `project_and_stakeholders`
--
ALTER TABLE `project_and_stakeholders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `project_and_tags`
--
ALTER TABLE `project_and_tags`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `project_and_theircontributors`
--
ALTER TABLE `project_and_theircontributors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `stakeholders`
--
ALTER TABLE `stakeholders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stakeholders_email_unique` (`email`);

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `user_and_educations`
--
ALTER TABLE `user_and_educations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_and_employments`
--
ALTER TABLE `user_and_employments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;
--
-- AUTO_INCREMENT для таблицы `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT для таблицы `project_and_contributors`
--
ALTER TABLE `project_and_contributors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `project_and_files`
--
ALTER TABLE `project_and_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `project_and_stakeholders`
--
ALTER TABLE `project_and_stakeholders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `project_and_tags`
--
ALTER TABLE `project_and_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `project_and_theircontributors`
--
ALTER TABLE `project_and_theircontributors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT для таблицы `stakeholders`
--
ALTER TABLE `stakeholders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `user_and_educations`
--
ALTER TABLE `user_and_educations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `user_and_employments`
--
ALTER TABLE `user_and_employments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
