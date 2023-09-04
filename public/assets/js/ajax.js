//////////////////Get AJAX//////////////////////////

function get_ajax(id,url,adress) {
url = url + "?id=" + id
fetch(url)
    .then((datas) => {
        datas.json().then(data=>{
            $.each(data, function (key, value) {
                console.log(value.nom)
            $(adress).append($("<option></option>").val(value.id).html(value.nom));
            })
        })
    })
}

function get_table_ajax(id,url,adress) {
  url = url + "?id=" + id
  $.ajax({
    type: 'GET',
     url: url,
    data: {'id':id},
    success: function (data) {
     $('#agent_count').html(data.count);
    $(adress).html(data.data);
    $(".paginate").html("")

    }, error: function (reject) {

    }
});
  }

  function get_table_ajax_find(text,url,adress) {
    url = url + "?text=" + text
    $.ajax({
      type: 'GET',
       url: url,
      data: {'text':text},
      success: function (data) {
      $(adress).html(data.data); 
      }, error: function (reject) {


      }
  });
    }
//////////////////Post AJAX//////////////////////////

function post_ajax(params) {
    //Obj of data to send in future like a dummyDb
 const data = { username: 'example' };

 //POST request with body equal on data in JSON format
 fetch('https://example.com/profile', {
   method: 'POST',
   headers: {
     'Content-Type': 'application/json',
   },
   body: JSON.stringify(data),
 })
 .then((response) => response.json())
 //Then with the data from the response in JSON...
 .then((data) => {
   console.log('Success:', data);
 })
 //Then with the error genereted...
 .catch((error) => {
   console.error('Error:', error);
 });

 //
 }


