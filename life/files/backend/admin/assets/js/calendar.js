(function($) {
  "use strict";

 /*----------------------------
      Calender Envent Active
    ------------------------------*/
  var alltaskRoute = $('input[name="renderTaskRoute"]').val()
  var modaltaskRoute = $('input[name="renderModalTaskRoute"]').val()
  var URL = $('input[name="baseUrl"]').val()
  var addCommentRoute = $('input[name="addCommentUrl"]').val()

  $("#myEvent").fullCalendar({
      height: 'auto',
      displayEventTime : false,
      header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay,listWeek'
    },
    defaultView: 'month',
    editable: true,
      events: function (start, end, timezone, callback) {
          $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
          $.ajax({
              url: alltaskRoute,
              type: 'POST',
              dataType: 'json',
              success: function (response) {
                  var events = [];
                  if (response) {
                      $.map(response, function (result) {
                          var task = result.task
                          events.push({
                              id: task.id,
                              parentId: task.task_id,
                              projectId: result.project_id,
                              title: task.name,
                              start: moment(task.due_date, "YYYY-MM-DD"),
                              backgroundColor: task.status == 1 ? "#007bff" : "#c53a3a",
                              borderColor: "#fff",
                              textColor: '#fff',
                          });
                          
                      });
                  }
                  callback(events);
              }
          });
      },
      eventClick: function (info) {
          loadModalData(info.parentId ?? info.id, info.projectId, info.title);
          $('.modal').modal('show')
      }  
  });

  /*-------------------
      Load More Data 
    ------------------------*/
  function loadModalData(id, project_id = '', name = '') {
    var modal = $('#exampleModal');
    var commentForm = $('.commentForm');
    var html = "", file = "";
    var input_task_id = commentForm.find('input[name="task_id"]')
    var input_project_id = commentForm.find('input[name="project_id"]')
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $.ajax({
      type: 'POST',
      url:  modaltaskRoute,
      data: {id:id},
      dataType: 'json',
      success: function(response){
          if (response) {
          console.log(response)
          let taskname = name ?? response.task.name
          if (response.comment.length > 0) {
            for(let i in response.comment){
              let comment = response.comment[i]
                html += `<li class="list-group-item border-0 shadow-sm p-3 mb-2 bg-white rounded">` 
                html += `<div class="row">`
                html += `<div class="col-md-8">${comment.user.name}</div>`
                html += `<div class="col-md-4 text-right">${comment.created_at ? moment(comment.created_at).format('MM/DD/YYYY') : 'None'} </div>`
                html += `<div class="col-md-12">`
                html += `<i>`
                html += `<strong>${comment.comment}</strong>`
                html += `</i>`
                if (comment.attachment != null && comment.attachment.file_name != "") {
                  let attachment = comment.attachment.file_name
                  file += `<li class="list-group-item border-0 shadow-sm p-3 mb-2 bg-white rounded">` 
                  file += `<div class="row">`
                  file += `<div class="col-md-12">`
                  file += `<a target="_blank" href="${URL}/${attachment}">`
                  file += `<i class="fas fa-paperclip"></i>`
                  file +=  attachment.substring(attachment.lastIndexOf('/') + 1)
                  file += `</a>` 
                  file += `</div>`
                  file += `</div>`
                  file += `</li>`
                  html += `<a target="_blank" href="${URL}/${attachment}"><i class="fas fa-paperclip"></i></a>`
              }
              html += `</div>`
              html += `</div>`
              html += `</li>`
            }
          }
          input_task_id.val(id);
          input_project_id.val(project_id);
          modal.find('.modal-title').html(taskname);
          modal.find('.all_comments').html(html);
          modal.find('.all_attachments').html(file);
          modal.modal('show');
          
        }
      } 
    });
  }

  /*--------------------------
      Comment Form Submit
    -----------------------------*/
  $('.commentForm').on('submit', function(e){
      e.preventDefault();
      var modal = $('#exampleModal');
      var form = this;
      var html = '', file = '';
      var data = new FormData(this);
      var comment =  $(this).find('textarea[name="comment"]');
      if (comment.val() === "") {
        return 
      }
      $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
      });
      $.ajax({
        type: 'POST',
        url:  addCommentRoute,
        data: data,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response){ 
          $('#imageShow').html("");
          form.reset();
          html += `<li class="list-group-item border-0 shadow-sm p-3 mb-2 bg-white rounded">` 
          html += `<div class="row">`
          html += `<div class="col-md-8">${response.name}</div>`
          html += `<div class="col-md-4 text-right">${moment(response.created_at).format('MM/DD/YYYY')} </div>`
          html += `<div class="col-md-12">`
          html += `<i>`
          html += `<strong>${response.comment}</strong>`
          html += `</i>`
          if (response.file != '') {
            let attachment = response.file
            file += `<li class="list-group-item border-0 shadow-sm p-3 mb-2 bg-white rounded">` 
            file += `<div class="row">`
            file += `<div class="col-md-12">`
            file += `<a target="_blank" href="${URL}/${attachment}">`
            file += `<i class="fas fa-paperclip"></i>`
            file +=  attachment.substring(attachment.lastIndexOf('/') + 1)
            file += `</a>` 
            file += `</div>`
            file += `</div>`
            file += `</li>`
            html += `<a target="_blank" href="${URL}/${attachment}"><i class="fas fa-paperclip"></i></a>`
          }

          html += `</div>`
          html += `</div>`
          html += `</li>`
          modal.find('.all_comments').prepend(html);
          modal.find('.all_attachments').prepend(file);
        }
      })
  })

  /*-------------------------------------
      custom image select name preview 
    ---------------------------------------*/
  $('.imageSelect').on('input', function() {
      var imgBox = $('#imageShow');
      var filename = $(this).val().split('\\').pop();
      var html = "";
      if (filename != "") {
      html += `<i class="fas fa-paperclip text-primary"></i> ` + filename;
      html += `<span class="closeFile"><i class="fas fa-times"></i></span>`;
      }
      imgBox.html(html);
  })

})(jQuery);