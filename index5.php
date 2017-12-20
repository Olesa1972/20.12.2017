<?php // таблица с фамилия предмет и оценка
$dbParams = require (
	'db.php'
);

$db=new PDO(
	"mysql: host=localhost; dbname=".
	$dbParams['database'].
	"; charset=utf8",// dbname- имя бд, host- имя хоста, charset-кодировка  (подключились к бд в резульитате создался PDO)
	$dbParams['username'],
	$dbParams['password']
); 
$marksQuery=$db
->prepare ('
SELECT `student`.`lastName`, `subject`.`name`,`mark`.`value` FROM `mark`
INNER JOIN `student`
ON `student`.`id`=`mark`.`studentId`
INNER JOIN `course` ON `mark`.`courseId`=`course`.`id`
INNER JOIN `subject`ON `subject`.`id`=`course`.`subjectId`
');
$marksQuery
	->execute();
$marks=$marksQuery
-> fetchAll(PDO :: FETCH_ASSOC);



?>
<html>
	<body>
		<table>
			<tr>
				<th>Фамилия</th>
				<th>Дисциплина</th>
				<th>Оценка</th>
			<tr>
			<?php foreach ($marks as $mark){ ?>
			<tr>
		
				<td><?=htmlspecialchars ($mark['lastName']) ?></td>
				<td><?=htmlspecialchars ($mark['name']) ?></td>
				<td><?=htmlspecialchars ($mark['value']) ?></td>
			<tr>
			<?php } ?>
		</table>
	</body>
</html>