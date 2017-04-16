<html>
    <head>
         <style>
table, th, td {
    border: 1px solid black;
}
.box {
  display: inline-block;
  width: 400px;
  height: auto;
  margin: 1em;
  border: solid #6AC5AC 3px;
  position: relative;
}
.after-box {
  clear: left;
}
</style>
    </head>
<body>

<div class="box" >
    <h1>Buscar en Netflix</h1>
<form action="netflix_query.php" method="get">
Nombre del Director: <input type="text" name="director"><br>
<input type="submit" value="consultar en netflix">
</form>
</div>

<div class="box" >
    <h1>Buscar en itunes</h1>
<form action="itunes_query.php" method="get">
Nombre del cantante: <input type="text" name="term"><br>
<input type="submit" value="consultar en itunes">
</form>
</div>

</body>
</html>