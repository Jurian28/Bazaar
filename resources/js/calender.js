
function createCalender(month, events) {
    let body = document.body;
    let grid = document.createElement("div");
    grid.style.display = "grid";
    grid.style.gridTemplateColumns = "repeat(7, 1fr)";
    grid.style.gap = "1px";

    const dayNames = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
    const dateToday = Date.now();

    // for (let)


}

createCalender(2, events);
