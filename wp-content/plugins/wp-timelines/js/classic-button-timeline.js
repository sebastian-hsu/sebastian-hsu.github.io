// JavaScript Document
(function() {
    tinymce.PluginManager.add('wpex_timeline', function(editor, url) {
		editor.addButton('wpex_timeline', {
			text: '',
			tooltip: 'Timeline',
			id: 'wpex_timeline_id',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Timeline',
					body: [
						
						{type: 'listbox',
							name: 'style',
							label: 'Style',
							'values': [
								{text: 'Classic', value: ''},
								{text: 'Modern', value: 'modern'},
								{text: 'Wide image', value: 'wide_img'},
								{text: 'Background', value: 'bg'},
								{text: 'Simple', value: 'simple'},
								{text: 'Clean', value: 'clean'},
							]
						},
						{type: 'listbox',
							name: 'alignment',
							label: 'Alignment',
							'values': [
								{text: 'Center', value: 'center'},
								{text: 'Left', value: 'left'},
							]
						},
						{type: 'textbox', name: 'posttype', label: 'Post type',  value: 'wp-timeline'},
						{type: 'textbox', name: 'ids', label: 'IDs'},
						{type: 'textbox', name: 'count', label: 'Count', value: '9'},
						{type: 'textbox', name: 'posts_per_page', label: 'Posts per page', value: '3'},
						{type: 'textbox', name: 'cat', label: 'Categories'},
						{type: 'textbox', name: 'tag', label: 'Tags'},
						{type: 'textbox', name: 'taxonomy', label: 'Taxonomy'},
						{type: 'listbox',
							name: 'order',
							label: 'Order',
							'values': [
								{text: 'Descending', value: 'DESC'},
								{text: 'Ascending', value: 'ASC'}
							]
						},
						{type: 'listbox', 
							name: 'orderby', 
							label: 'Order by', 
							'values': [
								{text: 'Date', value: 'date'},
								{text: 'Timeline Date', value: 'timeline_date'},
								{text: 'ID', value: 'ID'},
								{text: 'Author', value: 'author'},
								{text: 'Title', value: 'title'},
								{text: 'Name', value: 'name'},
								{text: 'Modified', value: 'modified'},
								{text: 'Parent', value: 'parent'},
								{text: 'Random', value: 'rand'},
								{text: 'Comment count', value: 'comment_count'},
								{text: 'Menu order', value: 'menu_order'},
								{text: 'Meta value', value: 'meta_value'},
								{text: 'Meta value num', value: 'meta_value_num'},
								{text: 'Post__in', value: 'post__in'},
								{text: 'None', value: 'none'}
							]
						},
						{type: 'textbox', name: 'meta_key', label: 'Meta key (Name of meta key for ordering)'},
						{type: 'textbox', name: 'start_label', label: 'Start label'},
						{type: 'textbox', name: 'end_label', label: 'End label'},
						{type: 'listbox',
							name: 'show_media',
							label: 'Show media',
							'values': [
								{text: 'Yes', value: '1'},
								{text: 'No', value: '0'},
								
							]
						},
						{type: 'listbox',
							name: 'show_history',
							label: 'Show history bar',
							'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'},
								
							]
						},
						{type: 'listbox',
							name: 'full_content',
							label: 'Show full Content',
							'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'},
								
							]
						},
						{type: 'listbox',
							name: 'filter_cat',
							label: 'Show Filter by category',
							'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'},
								
							]
						},
						{type: 'listbox',
							name: 'feature_label',
							label: 'Show Feature label',
							'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'},
								
							]
						},
						{type: 'listbox',
							name: 'hide_img',
							label: 'Hide Featured Image',
							'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'},
								
							]
						},
						{type: 'listbox',
							name: 'lightbox',
							label: 'Enable image lightbox',
							'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'},
								
							]
						},
						{type: 'listbox',
							name: 'infinite',
							label: 'Enable infinite Scroll',
							'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'},
								
							]
						},
						{type: 'textbox', name: 'animations', label: 'Animations'},
						{type: 'textbox', name: 'class', label: 'Css Class'},
					],
					onsubmit: function(e) {
						// Insert content when the window form is submitted
						 //var uID =  Math.floor((Math.random()*100)+1);
						 editor.insertContent('[wpex_timeline style="' + e.data.style + '" alignment="' + e.data.alignment + '" posttype="' + e.data.posttype + '" count="' + e.data.count + '" posts_per_page="' + e.data.posts_per_page + '" ids="' + e.data.ids + '" cat="' + e.data.cat + '"  tag="' + e.data.tag + '" taxonomy="' + e.data.taxonomy + '"  order="' + e.data.order + '"  orderby="' + e.data.orderby + '" meta_key="' + e.data.meta_key + '" start_label="' + e.data.start_label + '" end_label="' + e.data.end_label + '" show_media="' + e.data.show_media + '" animations="' + e.data.animations + '" show_history="' + e.data.show_history + '" full_content="' + e.data.full_content + '" filter_cat="' + e.data.filter_cat + '" feature_label="' + e.data.feature_label + '" hide_img="' + e.data.hide_img + '" lightbox="' + e.data.lightbox + '" infinite="' + e.data.infinite + '" class="' + e.data.class + '"]');
					}
				});
			}
		});
	});
})();
