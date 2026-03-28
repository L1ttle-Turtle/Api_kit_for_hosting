<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Demo Dashboard</title>

<style>
body { font-family: Arial; padding:20px; }

h3 { margin-bottom:10px; }

.red { color:red; font-weight:bold; font-size:18px; }

.filter-box { margin-bottom:15px; }

button {
    padding:6px 12px;
    background:#2d89ef;
    color:white;
    border:none;
    cursor:pointer;
}

.table-wrapper {
    overflow-x:auto;
    margin-top:15px;
}

table {
    border-collapse: collapse;
    min-width:800px;
}

th, td {
    border:1px solid #ccc;
    padding:6px;
    text-align:center;
    white-space:nowrap;
}

th { background:#f2f2f2; }

td:nth-child(2), th:nth-child(2) {
    text-align:left;
    padding-left:10px;
}
</style>
</head>

<body>

<h3>
Thống kê trong ngày :
<span class="red" id="todayTotal">0</span>
</h3>

<div class="filter-box">
<input type="date" id="fromDate">
 →
<input type="date" id="toDate">
<button id="btnSearch">Search</button>
</div>

<div class="table-wrapper">
<table>
<thead>
<tr id="tableHeader">
<th>STT</th>
<th>Website</th>
</tr>
</thead>
<tbody id="tableBody"></tbody>
</table>
</div>

<script>

const API_URL = "<?= site_url('api/statistics') ?>";

document.getElementById("btnSearch").addEventListener("click", loadData);

/* ===== FORMAT DATE KHÔNG LỆCH TIMEZONE ===== */
function formatDate(d){
    let date = new Date(d);
    let y = date.getFullYear();
    let m = String(date.getMonth()+1).padStart(2,'0');
    let day = String(date.getDate()).padStart(2,'0');
    return `${y}-${m}-${day}`;
}

/* ===== DEFAULT DATE ===== */
function getToday(){
    return formatDate(new Date());
}

function getLast7Days(){
    let d = new Date();
    d.setDate(d.getDate()-6);
    return formatDate(d);
}

function initDates(){
    document.getElementById("toDate").value = getToday();
    document.getElementById("fromDate").value = getLast7Days();
}

/* ===== GIỚI HẠN 60 NGÀY ===== */
function daysBetween(from,to){
    return (new Date(to) - new Date(from)) / (1000*60*60*24);
}

/* ===== LOAD DATA ===== */
function loadData(){

    let from = document.getElementById("fromDate").value;
    let to   = document.getElementById("toDate").value;

    if(!from || !to) return;

    if(daysBetween(from,to) > 60){
        alert("Chỉ được xem tối đa 60 ngày");
        return;
    }

    fetch(API_URL + "?from=" + from + "&to=" + to)
    .then(res => {
        if(!res.ok) throw new Error("API error");
        return res.json();
    })
    .then(data => {
        console.log(data);
        renderTable(data);
    })
    .catch(err=>{
        console.error(err);
        alert("Không lấy được dữ liệu từ API");
    });
}

/* ===== RENDER TABLE ===== */
function renderTable(res){

    const header = document.getElementById("tableHeader");
    const body   = document.getElementById("tableBody");

    body.innerHTML = "";
    header.innerHTML = "<th>STT</th><th>Website</th>";

    if(!res.dates || !res.data){
        body.innerHTML = "<tr><td colspan='2'>Không có dữ liệu</td></tr>";
        return;
    }

    // header ngày
    res.dates.forEach(d=>{
        header.innerHTML += "<th>"+d+"</th>";
    });

    document.getElementById("todayTotal").innerText = res.today_total || 0;

    // data row
    res.data.forEach((row,i)=>{

        let tr = "<tr>";
        tr += "<td>"+(i+1)+"</td>";
        tr += "<td>"+row.website+"</td>";

        res.dates.forEach(d=>{
            tr += "<td>"+(row.stats[d] || 0)+"</td>";
        });

        tr += "</tr>";

        body.innerHTML += tr;
    });

}

initDates();
loadData();

</script>

</body>
</html>