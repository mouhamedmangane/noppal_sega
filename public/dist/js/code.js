
function main(){
	treeList();
}

function treeList(){
	var toggler = document.getElementsByClassName("caret");
	var i;

	for (i = 0; i < toggler.length; i++) {
  		toggler[i].addEventListener("click", function() {
    	this.parentElement.querySelector(".nested").classList.toggle("active");
    	this.classList.toggle("caret-down");
  	});
	}
	/*init */
	$('#confirmation').hide();
	$
}

function disable_all_action(){
	$('.action-bar').children().prop('disabled',true);
}
function enable_all_action(){
	$('.action-bar').children().prop('disabled',false);
}
function active_confirmation() {
	$('.show-files-header').addClass('bg-dark p-2 text-white');
	$('#confirmation').show();
}
function disable_confirmation(){
	$('.show-files-header').removeClass('bg-dark p-2 text-white');
	$('#confirmation').hide();
}
function onModifier(){
	$('#modifier').click(function(){

		var file_name_checked = $('.checkbox:checked')
								.parent()
								.siblings('.name-file');
		file_name_checked.children('.name').hide();
		file_name_checked.append('<input type="text" name="up-name" class="up-name" />');
		$('.up-name').css('border','1px solid green');
		active_confirmation();
		$('.sidebar').fadeTo(0,.5);
		$('.up-name').first().focus();
		disable_all_action();
		$('#appliquer').click(function (event) {
			onAAppliqueUpdate();
		});
		$('#annuler').click(function (event) {
			$('.up-name').remove();
			$('.name').show();
			disable_confirmation();
			enable_all_action();

		});

	});
}
function onAAppliqueUpdate(){
	var form=$('#formSend');
	form.html('');
	form.prop('action','controllerUpdate');
	form.append('< input name = "directory" value='+$('#directory').html()+' >/')
	$('.up-name').each(function () {
		console.log($(this).siblings('.name').html());
		var old_name= $(this).siblings('.name').html();
		var new_name= $(this).val();
		//alert(old_name+' '+new_name);
		form.append('< input name = "oldname[]" value='+old_name+' >/');
		form.append('< input name = "newame[]" value='+new_name+' >/');
		;
	});
	form.submit(function(event){
		event.preventDefault();
		$.ajax({
			url:'localhost/index.html',
			type:'GET',
			data:$(this).serialize(),
			success:function(result){
				$("#show-files").html(result);

			}

		});
	});
}

main();
onModifier();

