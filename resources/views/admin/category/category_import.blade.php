@extends('layouts.app')


@section('content')

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
        
        <div class="row">
          
          <div class="col-md-offset-2 col-md-8">
          
            <div class="box box-info">
            <div class="box-header with-border">
              <a href="{{ URL::to('categorydownloadExcel/sample') }}"><button class="btn btn-default btn-flat btn-border-info"><span class="fa fa-download"> &nbsp;</span>{{ trans('message.table.download_sample') }}</button></a>
            </div>
            
            <div class="box-body">
            <div class="tab-content">
                <p>{{ trans('message.table.category_import_message') }}</p>
                <small class="text-red">{{ trans('message.table.duplicate_category') }}</small><br><br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>{{ trans('message.form.category') }}</th>
                      <th>{{ trans('message.table.unit') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ trans('message.table.sample_data') }}</td>
                      <td>{{ trans('message.table.sample_data') }}</td>
                    </tr>
                    <tr>
                      <td>{{ trans('message.table.sample_data') }}</td>
                      <td>{{ trans('message.table.sample_data') }}</td>
                    </tr>
                  </tbody>
                </table>
            </div><br/><br/>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('categoryimportcsv') }}" method="post" id="myform1" class="form-horizontal" enctype="multipart/form-data">
            {!! csrf_field() !!}
                <div class="form-group">
                  <label class="col-sm-2 control-label require" for="inputEmail3"> Choose CSV File</label>

                  <div class="col-sm-5">
                    <input type="file" class="form-control valdation_check input-file-field" id="name" name="import_file">
                    <span id="val_name" style="color: red"></span>
                  </div>
                </div><br/><br/>
            
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{ url('item-category') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                <button class="btn btn-primary btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          </div>
          </div>
          
        </div>
        
        <!-- /.box-footer-->
      
      <!-- /.box -->

    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $('#myform1').on('submit',function(e) {
                var flag = 0;
                $('.valdation_check').each(function() {
                    var id = $(this).attr('id');
                    console.log($('#'+id).val());
                    if($('#'+id).val() == '')
                    {
                        $('#val_'+id).html("{{ trans('message.error.required') }}");
                        flag = 1;
                    }
                });
                $('.valdation_select').each(function() {
                    var id = $(this).attr('id');
                    //console.log($('#'+id).val());
                    if ($('#'+id).val() == '') {
                    
                        $('#val_'+id).html("{{ trans('message.error.required') }}");
                        flag = 1;
                        //console.log('country '+flag);
                    }
                });
                if (flag == 1) {
                    e.preventDefault();
                }
        });
        $(".valdation_check").on('keypress keyup',function() {
            var nm = $(this).attr("id");
            $('#val_'+nm).html("");
        });
        $(".valdation_select").on('click',function() {
            var nm = $(this).attr("id");
            $('#val_'+nm).html("");
        });
    </script>
@endsection
