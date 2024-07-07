#Создание таблицы
CREATE TABLE `names` (
  `id` int NOT NULL,
  `name` text
);

#Заполнение таблицы
INSERT INTO `names` (`id`, `name`) VALUES
(1, '[value-1]'),
(2, '[value-2]'),
(2, '[value-3]'),
(4, '[value-4]'),
(5, '[value-5]'),
(5, '[value-6]'),
(6, '[value-7]'),
(7, '[value-8]');

#Выборка дубликатов с использованием оконной функции. Работает в версиях выше MySql 8.0
#Выводит только дубликат
SELECT `id`, `name`
FROM (
	SELECT `id`, `name`, ROW_NUMBER() OVER(PARTITION BY `id`) dublicate_rank 
	FROM `names`
) AS `windows`
WHERE `dublicate_rank` > 1;

#Выборка стандартными операторами и функциями. Работает во всех версиях MySql
#Выводит оригинал и дубликат
SELECT DISTINCT `names`.`id`, `names`.`name`
FROM `names`
INNER JOIN ( 
    SELECT `id` 
    FROM `names` 
    GROUP BY `id` 
    HAVING COUNT(`id`) > 1
) AS `dublicate`
ON 
`names`.`id` = `dublicate`.`id`;
