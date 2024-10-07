$.bsCalendar.setDefaults({
  locale: "en",
  url: "ajax/calendar_req.php",
  classes: {
    tableData: {
      notInMonth: "text-muted fw-small border-0 opacity-25",
    },
  },
});
// $.bsCalendar.setDefault('width', 5000);

$("#calendar_inline").bsCalendar({
  locale: "en",
  width: "100%",
  classes: {
    table: "table",
    tableHeaderCell: "text-muted fw-lighter",
    tableHeaderCellActive: "text-success fw-bold",
    tableData: {
      all: "rounded-circle w-100 h-100 border border-2",
      today: "border-info border-4",
      hover: "opacity-75",
      active: "border-secondary",
      inMonth: "fw-bold cursor-pointer",
      notInMonth: "text-muted fw-small border-0 opacity-25",
      eventCounter:
        "start-50 bottom-0 translate-middle-x bg-danger rounded-pill",
    },
  },
  event: {
    formatter(event) {
      let startDate = new Date(event.start).toLocaleString();
      let endDate = new Date(event.end).toLocaleString();

      return `
        <div class="row my-2">
            <div class="col-12 calendar-data">
                <div class="content">
                    <span class="members_"><strong>Total Members:</strong> ${event.members_}</span>
                    <span class="startDate"><strong>Time Start At:</strong> ${startDate}</span>
                    <span class="tables_"><strong>Total Tables:</strong> ${event.tables_}</span>
                    <span class="endDate"><strong>Time Ends At:</strong> ${endDate}</span>
                    <span class="location_"><strong>Table Location:</strong> ${event.table_location}</span>
                    <a href="#!" class="btn-example btn btn-sm btn-primary">more</a>
                </div>
            </div>
        </div>
    `;
    },
    events: {
      "click .btn-example"(e, event) {
        e.preventDefault();
        console.log(JSON.stringify(event));
      },
    },
  },
  dataSource(data) {
    return $.getJSON("ajax/calendar_req.php").then((json) => {
      return json;
    });
  },
});

// Handle events-loaded event
$("#calendar_inline").on("events-loaded", function (e, events) {
  // console.log(events);
  events.forEach((event) => {
    let date = event.start.split(" ");
    let startDate = date[0];
    // let startDate = new Date(event.start).toDateString();
    $(`td[data-date='${startDate}']`).addClass("disabled-date");
    $(`td[data-date='${startDate}']`)
      .children("div")
      .addClass("border-success border-4");
  });
});

$("#calendar_inline").on("change-day", function (e, date, events) {
  if (events.length > 0) {
    let date = events[0].start.split(" ");
    let currentDate = date[0];
    $(`td[data-date]`).children("div").removeClass("border-danger");
    $(`td[data-date='${currentDate}']`)
      .children("div")
      .addClass("border-danger");
    // events.forEach(element => {
    //     console.log(element.start);
    // });
  } else {
    $(`td[data-date]`).children("div").removeClass("border-danger");
    // console.log("no data yet!");
  }
});
