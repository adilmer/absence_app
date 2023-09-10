function get_ajax(id,url,adress){url=url+"?id="+id
fetch(url).then((datas)=>{datas.json().then(data=>{$.each(data,function(key,value){console.log(value.nom)
$(adress).append($("<option></option>").val(value.id).html(value.nom));})})})}
function get_table_ajax(id,url,adress){url=url+"?id="+id
$.ajax({type:'GET',url:url,data:{'id':id},success:function(data){$('#agent_count').html(data.count);$(adress).html(data.data);$(".paginate").html("")},error:function(reject){}});}
function get_table_ajax_find(text,url,adress){url=url+"?text="+text
$.ajax({type:'GET',url:url,data:{'text':text},success:function(data){$(adress).html(data.data);},error:function(reject){}});}