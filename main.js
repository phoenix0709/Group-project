// Flag chính xác
const correctFlag = "Solve this challenge!";

// Bảng xếp hạng giả lập
let leaderboard = [
    { rank: 1, player: "Player1", score: 100 },
    { rank: 2, player: "Player2", score: 90 },
    { rank: 3, player: "Player3", score: 80 }
];

// Hiển thị bảng xếp hạng
function displayLeaderboard() {
    const leaderboardBody = document.getElementById("leaderboard-body");
    leaderboardBody.innerHTML = "";
    leaderboard.forEach(player => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${player.rank}</td>
            <td>${player.player}</td>
            <td>${player.score}</td>
        `;
        leaderboardBody.appendChild(row);
    });
}

// Kiểm tra flag
function submitFlag() {
    const flagInput = document.getElementById("flag-input").value;
    const resultMessage = document.getElementById("result-message");

    if (flagInput === correctFlag) {
        resultMessage.style.color = "green";
        resultMessage.textContent = "Chúc mừng! Bạn đã giải đúng thử thách.";
    } else {
        resultMessage.style.color = "red";
        resultMessage.textContent = "Sai rồi! Hãy thử lại.";
    }
}

// Hiển thị bảng xếp hạng khi trang được tải
window.onload = displayLeaderboard;
