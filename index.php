<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="styl.css">
  <link rel="icon" type="image/gif" href="/images/fav.gif">
</head>
<body>

  <div class="header">
    <img src="/images/ob.png" alt="ob" />
    <h1><a href="signin">login/signup</a></h1>
   
  </div>

  <button class="tablink" onclick="openPage('Home', this, 'red')">Home</button>
  <button class="tablink" onclick="openPage('Coins', this, 'green')" id="defaultOpen">Coins</button>
  <button class="tablink" onclick="openPage('Favorites', this, 'blue')">Favorites</button>

  <div id="Home" class="tabcontent">

<table class="table1">
  <tr>
    <th>OVERSOLD</th>
  </tr>
  <tr>
    <td>Ethereum (ETH)</td>
  </tr>
  <tr>
    <td>Bitcoin (BTC)</td>
  </tr>
  <tr>
    <td>Chainlink (LINK)</td>
  </tr>
  <tr>
    <td>Cardano (ADA)</td>
  </tr>
  <tr>
    <td>Solana (SOL)</td>
  </tr>
</table>
<h2>

</h2>
<table class="table2">
  <tr>
    <th>OVERBOUGHT</th>
  </tr>
  <tr>
    <td>Polygon (MATIC)</td>
  </tr>
  <tr>
    <td>Polkadot (DOT)</td>
  </tr>
  <tr>
    <td>Litecoin (LTC)</td>
  </tr>
  <tr>
    <td>Algorand (ALGO)</td>
  </tr>
  <tr>
    <td>Uniswap (UNI)</td>
  </tr>
</table>
  </div>
  
  <div id="Coins" class="tabcontent">
    <table class="table3">
      <tr>
        <th>COINS</th>
      </tr>
      <tr>
        <td>Ethereum (ETH)</td>
        <td>Polygon (MATIC)</td>
      </tr>
      <tr>
        <td>Bitcoin (BTC)</td>
        <td>Polkadot (DOT)</td>
      </tr>
      <tr>
        <td>Chainlink (LINK)</td>
        <td>Litecoin (LTC)</td>
      </tr>
      <tr>
        <td>Cardano (ADA)</td>
        <td>Algorand (ALGO)</td>
      </tr>
      <tr>
        <td>Solana (SOL)</td>
        <td>Uniswap (UNI)</td>
      </tr>
    </table>
  </div>
  
  <div id="Favorites" class="tabcontent">
  <table class="table4">
  <tr>
    <th>FAVORITES</th>
  </tr>
  <tr>
    <td>Ethereum (ETH)</td>
  </tr>
  <tr>
    <td>Bitcoin (BTC)</td>
  </tr>
  <tr>
    <td>Chainlink (LINK)</td>
  </tr>
  <tr>
    <td>Cardano (ADA)</td>
  </tr>
  <tr>
    <td>Solana (SOL)</td>
  </tr>
</table>
  </div>
  
  
  <script>
  function openPage(pageName,elmnt,color) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].style.backgroundColor = "";
    }
    document.getElementById(pageName).style.display = "block";
    elmnt.style.backgroundColor = color;
  }
  
  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();
  </script>
     
</body>
<footer>
  <p>Author: William Kenny</p>
  <p><a href="williamkenny80@gmail.com">williamkenny80@gmail.com</a></p>
</footer>
</html>