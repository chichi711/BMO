
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><button type="button" class="btn  float-sm-left btn-default" id="show_btn" data-widget="pushmenu" style="margin-right: 10px;"><i class="fas fa-bars"></i></button> 
            <?= $title ?></h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content row" id="app">

      <!-- 輸入框開始 box -->
      <div class="col-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">發布公告</h3>

          <div class="card-tools">
            <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button> -->
          </div>
        </div>
        <div class="card-body">
          <div class="form-group">
              <input type="text" class="form-control subject"  placeholder="請輸入標題" value="" v-model="subject" >
          </div>
          <div class="form-group">
            <textarea class="form-control" name="" id="" rows="15" v-model="text_info" placeholder="請輸入公告內容"></textarea>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="button" class="btn btn-success" v-on:click="add($event)">送出新增</button>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
      </div>
      <!-- 輸入框結束 box -->

       <!-- 列表開始 -->
       <div class="col-6" >
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">公告列表</h3>

          <div class="card-tools">
            
          </div>
        </div>
        <div class="card-body" >
          <div v-for="item in bulletin_board" class="callout callout-success"  :sn="item.sn" >
              
              <h5 class="eye_subject">{{ item.subject }}</h5>
              <p v-html="item.html_info" class="show_info" style="display:none;"></p>
              <div class="card-tools">
                <button type="button" class="btn btn-info btn-sm eye" :sn="item.sn" @click="show = !show" >
                  <i class="far fa-eye"></i>
                </button>
                <button type="button" class="btn btn-success btn-sm" :sn="item.sn" :info="item.info" :subject="item.subject" v-on:click="open_edit($event)">
                  <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm" :sn="item.sn" v-on:click="remove_once($event)">
                  <i class="fas fa-trash"></i>
                </button>
                <span style="font-size:10px;color:#333;">最後更新：{{item.manager_id}} @ {{item.update_datetime}}</span>
              </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <!-- Footer -->
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
      </div>
       <!-- 列表結束 -->



  <!-- 編輯 Modal -->
  <div class="modal fade" id="show_edit_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      
      <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">編輯</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
          <input type="hidden" class="sn" v-model="edit_form.sn">
          <div class="modal-body">
              <div class="form-group">
                  <input type="text" class="form-control subject"  placeholder="請輸入標題" value="" v-model="edit_form.subject" >
              </div>
              <div class="form-group">
                <textarea class="form-control" name="" id="" rows="15" v-model="edit_form.info" placeholder="請輸入公告內容"></textarea>
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" v-on:click="update($event)" >Save changes</button>
      </div>
      </div>
  </div>
  </div>




    </section>
    <!-- /.content -->





<script src="https://cdn.bootcss.com/qs/6.7.0/qs.min.js"></script>
<script>
  $(function(){
    $(".show_info").eq(0).show();
    $("body").on("click",".eye",function(){
        $(".show_info").hide();
        $(this).parent().prev().show(200);
    })
    $("body").on("click",'.eye_subject',function(){
        $(".show_info").hide();
        $(this).next().show(200);
    })
  })

  var app = new Vue({
    el:"#app",
    data:{
      bulletin_board:[],
      text_info:"",
      sn:"",
      subject:"",
      edit_form:{
        sn:"",
        subject:"",
        info:""
      }
        
      
    },
    mounted(){
      var _this = this;
      _this.bulletin_board_list()
    },
    methods:{
      bulletin_board_list(){
        var _this = this;
        axios({
            method : 'post',
            url : './api/bulletin_board_list',
            responseType : 'json', 
        })
        .then(function (data) {
          data = data.data;
          console.log(data);
          _this.bulletin_board = data.data;
        })
      },
      add(e){
        var _this = this;
        var chk = true;
        if(_this.text_info == ''){
          chk = false;
        }
        if(_this.subject == ""){
          chk = false;
        }
        if(chk  == false){
          Swal.fire('Oops!','所有欄位都要填寫喔','error');
          return false;
        }
        send_data = Qs.stringify({
              manager_id:'<?=session('manager')['manager_id']?>',
              sn : '',
              info : _this.text_info,
              subject:_this.subject
          })
          _this.send_set(send_data)
      },
      update(e){
        var _this = this;
        var chk = true;
        if(_this.edit_form.info == ''){
          chk = false;
        }
        if(_this.edit_form.subject == ""){
          chk = false;
        }
        if(chk  == false){
          Swal.fire('Oops!','所有欄位都要填寫喔','error');
          return false;
        }
        send_data = Qs.stringify({
            manager_id:'<?=session('manager')['manager_id']?>',
            sn : _this.edit_form.sn,
            info : _this.edit_form.info,
            subject:_this.edit_form.subject
        })
        _this.send_set(send_data)
        $("#show_edit_form").modal("hide");
      },
      send_set(send_data){
        var _this = this;
        axios({
            method : 'post',
            url : './api/bulletin_board_set',
            responseType : 'json', 
            data : send_data
            }).then(function (data) {
                data = data.data;
                console.log(data);
                _this.bulletin_board_list()
                _this.sn = ''
                _this.text_info = ''
                _this.subject = ''
                _this.edit_form.sn = '',
                _this.edit_form.subject = '',
                _this.edit_form.info = ''
        })
      },
      remove_once(e){
        var _this = this;
        var sn = e.currentTarget.getAttribute('sn');
        
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            axios({
                method : 'post',
                url : './api/bulletin_board_remove?sn='+sn,
                responseType : 'json'
            })
            .then(function (data) {
              _this.bulletin_board_list()
            })
            // var api = './api/product_remove';
            // $.post(api,{
            //   product_id:$(this).data('product_id')
            // },function(data){
            //     if(data.sys_code == '200'){
            //       Swal.fire('Good job!','資料處理完成','success').then(function(response){location.reload();});
            //     }else{
            //       Swal.fire('Oops!','資料錯誤','error');
            //     }
            // },'json');
          }
        })


        
      },
      open_edit(e){
        var _this = this;
        _this.edit_form.sn = e.currentTarget.getAttribute('sn');
        _this.edit_form.subject = e.currentTarget.getAttribute('subject');
        _this.edit_form.info = e.currentTarget.getAttribute('info');
        $("#show_edit_form").modal("show");
        
      }

    }
  })
</script>
