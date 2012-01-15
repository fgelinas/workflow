<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/workflow.css">
	<link rel="stylesheet" href="css/smoothness/jquery-ui-1.8.17.custom.css">
	<script src="js/jquery-1.7.1.min.js"></script>
	<script src="js/jquery-ui-1.8.17.custom.min.js"></script>

	<script src="js/workflow.js"></script>
</head>
<body>

<div id="wrapper">

	<div id="header">


		<h1>Workflow</h1>

		<div id="toolbar">

		</div>

		<div style="clear: both"></div>
	</div>

	<div id="content">



		<? foreach ($data->columns as $column ): ?>

			<?= Render::column($column); ?>

		<? endforeach; ?>

		<div style="clear: both"></div>

	</div>

	<div id="trash">

		Drop cards here to delete

	</div>

	<div id="auto_height" style="display: inline-block; position: absolute; visibility: hidden;" data-purpose='used by flow.js to calculate edit_box height'></div>



</div>





</div>


</body>

</html>