<?php
$count = 0;
include 'config.php';
if (isset($_GET['unm'])) {
	$_SESSION['stud'] = $_GET['unm'];
}
include 'header.php';
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Mulish:wght@200&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
<style>
	body {
		background-color: #ffebdb;
	}

	.inner {
		box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
		text-transform: uppercase;
	}

	body div {
		font-family: 'Mulish', sans-serif;
		font-size: 10px;
	}

	.carousel {
		margin: 0px 20px 0px 20px;
		box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
		transition: opacity 1s ease-in-out;
	}

	#card {
		margin: 20px 20px 0px 20px;
		box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
		height: 25px;
	}

	#card1 {
		margin: 0px 20px 0px 20px;
		box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
		height: 60px;
	}

	.fa-heart1 {
		width: 100px;
		height: 100px;
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%);
		background: url(heart.png) no-repeat;
		cursor: pointer;
	}

	img {
		height: 400px;
	}

	#nav {
		filter: invert(100%);
	}

	.fa-beat {
		animation: fa-beat .8s ease-in 1;
	}


	.carousel-indicators li {
		width: 10px;
		height: 10px;
		border-radius: 100%;
		background-color: #FF0000;
	}

	#sample {
		margin: 0px 20px 0px 20px;
		height: 400px;
	}
</style>

<?php
$sql = "select DISTINCT `eventid` from `geetsocial` ORDER BY `added` DESC";
$res = mysqli_query($con, $sql);
$slider = 0;
$jq = 0;
while ($row = mysqli_fetch_assoc($res)) {
	$jq++;
	$i = 0;
	$j = 0;
	$k = 0;
	$eventid = $row['eventid'];
	$sql1 = "select * from `geetsocial` where `eventid`='$eventid'";
	$res1 = mysqli_query($con, $sql1);
	$res2 = mysqli_query($con, $sql1);
	$res3 = mysqli_query($con, $sql1);
	$rowjust = mysqli_fetch_assoc($res3);
	$getOnlyDate = date('d-m-Y', strtotime($rowjust['added']));
?>
	<div class="card" id="card">
		<div class="row mt-1">
			<div class="col"><b style="margin-left:10px;font-size:12px;">&nbsp;<?php echo $rowjust['added_by']; ?></b></div>
			<div class="col"><b style="margin-right:10px;float:right;font-size:12px;"><?php echo $getOnlyDate; ?></b></div>
		</div>
	</div>
	<?php
	if ($rowjust['eventimage'] != '') {
	?>
		<div id="carouselExampleIndicators<?php echo $slider; ?>" id="carousal" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#carouselExampleIndicators<?php echo $slider; ?>" data-slide-to="0" class="active"></li>
				<?php
				while ($row1 = mysqli_fetch_assoc($res1)) {
					if ($k == 0) {
						$k++;
						continue;
					}
					$i++;
				?>
					<li data-target="#carouselExampleIndicators<?php echo $slider; ?>" data-slide-to="<?php echo $i; ?>"></li>
				<?php
				}
				?>
			</ol>
			<div class="carousel-inner">
				<?php
				$row2 = mysqli_fetch_assoc($res2);
				?>
				<div class="carousel-item active"><input type="text" id="txtsid" value="<?php echo $sid; ?>" hidden><input type="text" id="txtpid" value="<?php echo $row2['eventid']; ?>" hidden>
					<img class="d-block w-100" src="<?php echo "https://geetanjaligroupofcolleges.in/student/Teachers/social/" . $row2['eventimage']; ?>">
				</div>
				<?php
				while ($row2 = mysqli_fetch_assoc($res2)) {
					if ($j == 1) {
						$j++;
						continue;
					}
				?>
					<div class="carousel-item">
						<img class="d-block w-100" src="<?php echo "https://geetanjaligroupofcolleges.in/student/Teachers/social/" . $row2['eventimage']; ?>">
					</div>
				<?php
				}
				?>
			</div>
			<a class="carousel-control-prev" href="#carouselExampleIndicators<?php echo $slider; ?>" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleIndicators<?php echo $slider; ?>" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	<?php
	} else {
	?>
		<div id="sample">
			<iframe height="400px" width="100%" src="<?php echo 'https://www.youtube.com/embed/' . $rowjust['video'] ?>?autoplay=0&showinfo=0&controls=0&modestbranding=0" frameborder="0"></iframe>
		</div>
	<?php
	}
	?>
	<div class="card" id="card1">
		<div class="row mt-1">
			<?php
			$pid = $rowjust['eventid'];
			$sqlgetlike = "select * from `likes` where `sid`='$sid' and `pid`='$pid'";
			$reslikes = mysqli_query($con, $sqlgetlike);
			$countlikes = mysqli_num_rows($reslikes);
			$sqltotallikes = "select * from `likes` where `pid`='$pid'";
			$restotallikes = mysqli_query($con, $sqltotallikes);
			$totalcount = mysqli_num_rows($restotallikes);
			if ($countlikes == 1) {
			?>
				<div class="col" style="margin-left:10px;height:auto;">
					<h5>
						<i id="<?php echo $rowjust['eventid']; ?>" onclick="addlike(<?php echo $rowjust['eventid']; ?>)" style="color:red;" class="fas fa-heart"><b style="margin-left:10px;font-size:12px;" id="ew<?php echo  $rowjust['eventid']; ?>"><?php echo $totalcount . " "; ?> Likes</b></i>
					</h5><b style="font-size:12px;"><?php echo $rowjust['eventtitle']; ?>
				</div>
			<?php
			} else {
			?>
				<div class="col" style="margin-left:10px;height:auto;">
					<h5><i id="<?php echo $rowjust['eventid']; ?>" onclick="addlike(<?php echo $rowjust['eventid']; ?>)" style="color:red;" class="far fa-heart"><b style="margin-left:10px;font-size:12px;" id="ew<?php echo  $rowjust['eventid']; ?>"><?php echo $totalcount . " "; ?> Likes </b> </i></h5><b style="font-size:12px;"><?php echo $rowjust['eventtitle']; ?>
				</div>
			<?php
			}
			?>
			<div class="col"><b style="margin-right:10px;float:right;"><button type="button" class="btn btn-primary btn-sm" id="txtxttxt" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $rowjust['eventdescription']; ?>" data-whatever1="<?php echo $rowjust['eventtitle']; ?>">Read More</button></b></div>
		</div>
	</div>
<?php
	$slider++;
}
?>
<script>
	$('#carousal').carousel({
		interval: 2000
	})

	$(".fa-heart").on('click touchstart', function() {
		$(this).toggleClass('fa-beat');
	});

	function addlike(id) {
		var sid = $('#txtsid').val();
		var pid = id;
		$.ajax({
			url: "setlikes.php",
			type: "POST",
			data: {
				sid: sid,
				pid: pid
			},
			cache: false,
			success: function(response) {
				//console.log(response)
				data1 = JSON.parse(response);
				if (data1[0] == "INSERTED") {
					$("#" + data1[2]).removeClass("far fa-heart").addClass("fas fa-heart fa-beat");
					$("#" + data1[2]).html('<b style="margin-left:10px;font-size:12px; " id="ew' + data1[2] + '">' + data1[1] + " Likes</b>");

					console.log(data1[1]);
					console.log("Added");

					console.log(data1[2]);
				} else if (data1[0] == "DELETED") {
					$("#" + data1[2]).removeClass("fas fa-heart");
					$("#" + data1[2]).addClass("far fa-heart fa-beat");
					$("#" + data1[2]).html('<b style="margin-left:10px;font-size:12px;" id="ew' + data1[2] + '">' + data1[1] + " Likes</b>");

					console.log(data1[1]);
					console.log("Removed");
					console.log(data1[2]);
				}
			}
		});
	}
</script>
<div class="modal fade" id="exampleModal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header text-white" style="background-color:#f17a07;">
				<h5 class="modal-title" id="exampleModalLabel">New message</h5>
				<button type="button" class="close" data-dismiss="modal" style="color:white;" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<p id="recipient-name" style="font-size:14px;"></p>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$('#exampleModal').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var recipient = button.data('whatever')
		var recipient1 = button.data('whatever1')
		var modal = $(this)
		modal.find('.modal-title').text(recipient1)
		modal.find('#recipient-name').text(recipient)
	})
</script>