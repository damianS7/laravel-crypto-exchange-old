<canvas id="depth_canvas"></canvas>
<script>
  var c = document.getElementById("depth_canvas");
  var ctx = c.getContext("2d");
  ctx.moveTo(0, 0);
  ctx.lineTo($('#depth_canvas').width(), $('#depth_canvas').height());
  ctx.stroke();
</script>