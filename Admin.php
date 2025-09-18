<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Constellation Cipher Admin</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #111;
      color: white;
      text-align: center;
      margin: 0;
      padding: 0;
    }
    h1 { color: #ffd700; padding: 20px; }
    label { display: block; margin: 15px; }
    input, select {
      padding: 10px;
      border-radius: 5px;
      border: none;
      font-size: 16px;
      margin-top: 5px;
    }
    button {
      margin: 20px;
      padding: 10px 20px;
      border-radius: 5px;
      border: none;
      background: #ffd700;
      font-size: 16px;
      cursor: pointer;
    }
    .answers {
      margin-top: 20px;
      font-size: 18px;
    }
    .answers span {
      display: block;
      margin: 5px 0;
      color: #00ffcc;
    }
  </style>
</head>
<body>

  <h1>⚙️ Admin Settings</h1>
  
  <label>
    Choose Constellation:
    <select id="starSelect"></select>
  </label>

  <!-- Show both clockwise and counterclockwise results -->
  <div class="answers">
    <span id="cwAnswer">Clockwise: —</span>
    <span id="ccwAnswer">Counterclockwise: —</span>
  </div>

  <button onclick="saveSettings()">Save Settings</button>
  <button onclick="goBack()">⬅️ Back to Game</button>

  <script>
  // 1. Define constellation star counts
  const constellations = {
    "Aries": 4,
    "Taurus": 19,
    "Gemini": 17,
    "Cancer": 5,
    "Leo": 13,
    "Virgo": 20,
    "Libra": 8,
    "Scorpio": 18,
    "Sagittarius": 12,
    "Capricorn": 9,
    "Aquarius": 10,
    "Pisces": 18
  };

  // 2. Caesar cipher function
  function caesarShift(str, shift) {
    return str.split("").map(char => {
      if (/[a-z]/.test(char)) { // lowercase
        let code = char.charCodeAt(0) - 97;
        return String.fromCharCode(((code + shift + 26) % 26) + 97);
      } else if (/[A-Z]/.test(char)) { // uppercase
        let code = char.charCodeAt(0) - 65;
        return String.fromCharCode(((code + shift + 26) % 26) + 65);
      }
      return char;
    }).join("");
  }

  // 3. Populate dropdown
  const sel = document.getElementById("starSelect");
  Object.keys(constellations).forEach(c => {
    const opt = document.createElement("option");
    opt.value = c;
    opt.textContent = c;
    sel.appendChild(opt);
  });

  // 4. Update answers function
  function updateAnswers(constellation) {
    let starCount = constellations[constellation];
    let baseWord = constellation;

    let cw = caesarShift(baseWord, starCount);
    let ccw = caesarShift(baseWord, -starCount);

    document.getElementById("cwAnswer").textContent = "Clockwise: " + cw;
    document.getElementById("ccwAnswer").textContent = "Counterclockwise: " + ccw;

    return {cw, ccw};
  }

  // 5. Auto-update answers when constellation is picked
  sel.addEventListener("change", function() {
    updateAnswers(this.value);
  });

  // 6. Save settings (save both answers)
  function saveSettings() {
    const star = document.getElementById("starSelect").value;
    const {cw, ccw} = updateAnswers(star);

    localStorage.setItem("cipherStar", star);
    localStorage.setItem("cipherAnswerCW", cw);
    localStorage.setItem("cipherAnswerCCW", ccw);

    alert("✅ Settings saved!\nConstellation: " + star + 
          "\nClockwise Answer: " + cw + 
          "\nCounterclockwise Answer: " + ccw);
  }

  // 7. Load previously saved constellation + answers
  window.onload = function() {
    let savedStar = localStorage.getItem("cipherStar");
    if (savedStar) {
      sel.value = savedStar;
      updateAnswers(savedStar);
    }
  }

  // 8. Back to game
  function goBack() {
    window.location.href = "Game.php";
  }
</script>

</body>
</html>