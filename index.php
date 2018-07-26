<?php
	require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Bookstore</title>
</head>
<body>
	<p><?php echo loginMessage(); ?></p>
	<?php 
		$booksJson = file_get_contents('books.json');
		$books = json_decode($booksJson, true);
		
		if(isset($_GET['title'])) {
			echo "<p>Looking for <b>". $_GET['title'] . '</b></p>';
			if (bookingBook($books, $_GET['title'])) {
				echo 'Booked!';
				updateBooks($books);
			}
			else
				echo 'The book is not available';
		}
		else
			echo "<p>You are not looking for a book?</p>";
	?>
	<ul>
		<?php foreach ($books as $book): ?>
			<li>
				<a href="?title=<?php echo $book['title']; ?>">
					<?php echo printTableTitle($book); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>

</body>
</html>
