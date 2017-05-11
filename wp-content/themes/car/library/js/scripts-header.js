	var $ = jQuery;  
    function vote(game_id, goal1, goal2, sdt){
        goal1 = $.trim(goal1);
        goal2 = $.trim(goal2);
        if(goal1==""||goal2==""){
            alert("Bạn chưa nhập tỉ số");            
            return;
        }else if(!isNumber(goal1) || !isNumber(goal2)){
            alert("Tỉ số không hợp lệ");
            return;
        }

        if(sdt ==""){
            alert("Bạn chưa nhập SĐT");
            return;
        }else if(!isNumber(sdt) || sdt.length < 10){
            alert("SĐT bạn nhập không hợp lệ");
            return;
        }

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: ({action: 'vote', game_id: game_id, goal1 : goal1, goal2 : goal2, sdt: sdt}),                       
            success: function(obj){                                                         
                var data = jQuery.parseJSON(obj);
                if(data.msg != ""){                                
                    if(data.msg != "null"){
                        alert(data.msg);
                    }
                }
                if(data.success){
                    $(".goal input, .input_sdt").val("");
                    $.cookie('dudoan-'+game_id, 'dudoan-'+game_id, { expires: 1 });
                    location.reload();
                }                               
            }                        
        });
    }	

    function isNumber(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }
