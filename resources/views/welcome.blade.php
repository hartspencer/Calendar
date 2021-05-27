<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Appetiser-test</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/daypilot-all.min.js')}}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body class="antialiased">
            


        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="sm:max-w-full mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

                <form onsubmit="submitAppetiserCalendar()" action="{{ route('calendar.create') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="grid grid-rows-3 grid-flow-col gap-4 pb-5">
                        <div class="row-span-1 col-span-2">
                            <label>Calendar<label>
                            <hr>
                        </div>

                        <div class="row-span-1  col-span-2">
                            <x-label for="name" :value="__('Event')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $event->name ? $event->name : ''}}" required autofocus />
                        </div>

                        <div class="row-span-1 col-span-1">
                            <x-label for="from" :value="__('From')" />

                            <x-input id="from" class="block mt-1 w-full" type="date" name="from" value="{{ $event->start ? $event->start : ''}}" required />
                        </div>

                        <div class="col-span-1">
                            <x-label for="to" :value="__('To')" />

                            <x-input id="to" class="block mt-1 w-full" type="date" name="to" value="{{ $event->end ? $event->end : ''}}" required />
                        </div>
                    </div>

                     <div class="row-span-5 col-span-1 pb-5">
                                <input name="mon" type="checkbox" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/
                                >:Monday
                                <input name="tue" type="checkbox" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/ 
                                >:Tuesday
                                <input name="wed" type="checkbox" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/
                                >:Wednesday
                                <input name="thu" type="checkbox" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/ 
                                >:Thursday
                                <input name="fri" type="checkbox" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/ 
                                >:Friday
                                <input name="sat" type="checkbox" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/ 
                                >:Saturday
                                <input name="sun" type="checkbox" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/ 
                                >:Sunday
                    </div>
                    <div class="flex items-center justify-center mt-4 pb-5">
                        <x-button class="ml-3">
                            {{ __('Save') }}
                        </x-button>
                    </div>
                </form> 

                  <div style="display:flex">
    <div style="display: none;">
      <div id="nav"></div>
    </div>
    <div style="flex-grow: 1; margin-left: 10px;">
      <div class="toolbar buttons hidden">
        <span class="toolbar-item"><a id="buttonDay" href="#">Day</a></span>
        <span class="toolbar-item"><a id="buttonWeek" href="#">Week</a></span>
        <span class="toolbar-item"><a id="buttonMonth" href="#">Month</a></span>
      </div>
      <div id="dpMonth"></div>
      <div id="dpDay"></div>
      <div id="dpWeek"></div>
    </div>
  </div>


            </div>
        </div>

         <script>
          var nav = new DayPilot.Navigator("nav");
          nav.showMonths = 3;
          nav.skipMonths = 3;
          nav.init();

          var day = new DayPilot.Calendar("dpDay");
          day.viewType = "Day";
          configureCalendar(day);
          day.init();

          var week = new DayPilot.Calendar("dpWeek");
          week.viewType = "Week";
          configureCalendar(week);
          week.init();

          var month = new DayPilot.Month("dpMonth");
          configureCalendar(month);
          month.init();

          function configureCalendar(dp) {
            dp.contextMenu = new DayPilot.Menu({
              items: [
                {
                  text: "Delete",
                  onClick: function(args) {
                    var params = {
                      id: args.source.id(),
                    };
                    DayPilot.Http.ajax({
                      url: "calendar_delete.php",
                      data: params,
                      success: function(ajax) {
                        dp.events.remove(params.id);
                        dp.message("Deleted");
                      }
                    });
                  }
                },
                {
                  text: "-"
                },
                {
                  text: "Blue",
                  icon: "icon icon-blue",
                  color: "#3d85c6",
                  onClick: function(args) { updateColor(args.source, args.item.color); }
                },
                {
                  text: "Green",
                  icon: "icon icon-green",
                  color: "#6aa84f",
                  onClick: function(args) { updateColor(args.source, args.item.color); }
                },
                {
                  text: "Orange",
                  icon: "icon icon-orange",
                  color: "#e69138",
                  onClick: function(args) { updateColor(args.source, args.item.color); }
                },
                {
                  text: "Red",
                  icon: "icon icon-red",
                  color: "#cc4125",
                  onClick: function(args) { updateColor(args.source, args.item.color); }
                }
              ]
            });


            dp.onBeforeEventRender = function(args) {
              if (!args.data.backColor) {
                args.data.backColor = "#6aa84f";
              }
              args.data.borderColor = "darker";
              args.data.fontColor = "#fff";
              args.data.barHidden = true;

              args.data.areas = [
                {
                  right: 2,
                  top: 2,
                  width: 20,
                  height: 20,
                  html: "&equiv;",
                  action: "ContextMenu",
                  cssClass: "area-menu-icon",
                  visibility: "Hover"
                }
              ];
            };

            dp.onEventMoved = function (args) {
              DayPilot.Http.ajax({
                url: "calendar_move.php",
                data: {
                  id: args.e.id(),
                  newStart: args.newStart,
                  newEnd: args.newEnd
                },
                success: function() {
                  console.log("Moved.");
                }
              });
            };

            dp.onEventResized = function (args) {
              DayPilot.Http.ajax({
                url: "calendar_move.php",
                data: {
                  id: args.e.id(),
                  newStart: args.newStart,
                  newEnd: args.newEnd
                },
                success: function() {
                  console.log("Resized.");
                }
              });

            };

            // event creating
            dp.onTimeRangeSelected = function (args) {

              var form = [
                {name: "Name", id: "text"},
                {name: "Start", id: "start", dateFormat: "MMMM d, yyyy h:mm tt", disabled: true},
                {name: "End", id: "end", dateFormat: "MMMM d, yyyy h:mm tt", disabled: true},
              ];

              var data = {
                start: args.start,
                end: args.end,
                text: "Event"
              };

              DayPilot.Modal.form(form, data).then(function(modal) {
                dp.clearSelection();

                if (modal.canceled) {
                  return;
                }

                DayPilot.Http.ajax({
                  url: "calendar_create.php",
                  data: modal.result,
                  success: function(ajax) {
                    var dp = switcher.active.control;
                    dp.events.add({
                      start: data.start,
                      end: data.end,
                      id: ajax.data.id,
                      text: data.text
                    });
                  }
                });

              });
            };

            dp.onEventClick = function(args) {
              DayPilot.Modal.alert(args.e.data.text);
            };
          }

          var switcher = new DayPilot.Switcher({
            triggers: [
              {id: "buttonDay", view: day },
              {id: "buttonWeek", view: week},
              {id: "buttonMonth", view: month}
            ],
            navigator: nav,
            selectedClass: "selected-button",
            onChanged: function(args) {
              console.log("onChanged fired");
              switcher.events.load("calendar_events.php");
            }
          });

          switcher.select("buttonMonth");

          function updateColor(e, color) {
            var params = {
              id: e.data.id,
              color: color
            };
            DayPilot.Http.ajax({
              url: "calendar_color.php",
              data: params,
              success: function(ajax) {
                var dp = switcher.active.control;
                e.data.backColor = color;
                dp.events.update(e);
                dp.message("Color updated");
              }
            });
              }


              function submitAppetiserCalendar(){
                    e.preventDefault(); // avoid to execute the actual submit of the form.

                    var form = $(this);
                    var url = form.attr('action');
                    
                    $.ajax({
                           type: "POST",
                           url: url,
                           data: form.serialize(), // serializes the form's elements.
                           success: function(data)
                           {
                               alert(data); // show response from the php script.
                           }
                    });
              }
        </script>

    </body>

</html>
