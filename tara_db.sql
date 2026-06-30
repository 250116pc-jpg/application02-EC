-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2026-06-30 09:43:40
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `tara_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `carts`
--

CREATE TABLE `carts` (
  `user_id` int(11) NOT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`items`)),
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` text NOT NULL,
  `explanation` text NOT NULL,
  `format` text NOT NULL,
  `is_sale` int(11) NOT NULL,
  `release_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `stock`, `image`, `explanation`, `format`, `is_sale`, `release_date`) VALUES
(1, '月光', 1400, 13, 'default.png', 'メディア掲載レビューほか\r\n{萌え}より{燃え}ゲーム・メーカーとして人気のニトロ・プラスの、大ヒットPCゲーム作品がOVAで登場。音楽を手がけるのは、PC版、PS2版でもお馴染みZIZZ#STUDIO。\r\n-- 内容（「CDジャーナル」データベースより）', 'CD', 1, '2026-06-30 09:36:03'),
(2, '君が望む永遠 コンプリート DVD-BOX (全14話, 300分) きみがのぞむえいえん 君望 きみのぞ アニメ [DVD] [Import] [PAL, 再生環境をご確認ください]', 100, 2, 'default.png', '', 'DVD', 1, '2026-06-30 09:39:19'),
(3, 'ef - the first tale.', 15000, 7, 'default.png', '18禁インタラクティブ・ノベル。現役の学生でありながら少女漫画家でもある広野紘。クリスマスの夜、彼は2人の少女と出会った。教会で誰かを待ち続けているという謎の女性・雨宮優子。ひったくりにバックを盗まれ、それを追いかけるために紘の自転車を奪った少女・宮村みやこ。\r\nその冬、紘は学業と作家・・・現実と夢のどちらを選ぶかという選択に揺れていた。なにものにも縛られず、自由に生きるみやこに惹かれていく紘。しかし、彼を見つめる少女が、もう1人いた。紘の幼なじみであり、妹のような存在でもある新藤景。小柄な身体にも関わらずバスケ部のレギュラー選手として活躍する彼女は、常に顔をあげ、前進し、みやことは別の道を紘に示していた。\r\n他愛ない学園生活のなかで触れあう、1人の少年と2人の少女。その関係は、やがて恋心へと移り変わってゆくが・・・その糸はひどくもつれていた。夢と現実の選択。2人の少女との関係。相対する2つの問題に、紘はひとつの答えをだす。\r\n原画は七尾奈留・がろあ、シナリオは御影・鏡遊が担当。\r\n審査番号:22880', 'DVD', 1, '2026-06-30 09:41:17'),
(4, 'X', 6000, 75, 'default.png', '『カードキャプターさくら』などで知られるCLAMPの人気コミックをアニメ化したファンタジー。地球の運命を握る少年・神威をめぐる超能力者たちの戦いを描く。\r\n-- 内容（「DVD NAVIGATOR」データベースより）\r\n\r\n監督・脚本: りんたろう 原作: CLAMP 脚本: 渡辺麻実/大川七瀬 作画監督・キャラクターデザイン: 結城信輝 音楽: 清水靖晃 声の出演: 関智一/岩男潤子/成田剣/山寺宏一/篠原恵美/田中秀幸/小山茉美/野上ゆかな/宮崎一成/井上和彦/三石琴乃/松本梨香/中田譲治/古澤徹/関俊彦/高畑淳子/皆口裕子/池田昌子\r\n-- 内容（「CDジャーナル」データベースより）', 'DVD', 1, '2026-06-30 09:42:58');

-- --------------------------------------------------------

--
-- テーブルの構造 `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`items`)),
  `pay` text NOT NULL,
  `method` text NOT NULL,
  `address` text NOT NULL,
  `delivery_date` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `address` text NOT NULL,
  `password` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`user_id`);

--
-- テーブルのインデックス `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `carts`
--
ALTER TABLE `carts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルの AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
