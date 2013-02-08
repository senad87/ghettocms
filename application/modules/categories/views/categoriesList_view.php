<!-- start holder_content -->
<div class="holder_content">
<h1><?php echo $this->lang->line('categories_title');?></h1>
<!-- start table -->
<a href="<?php echo base_url();?>categories/createNew/" >+Create New Category</a>
<table>
<thead>
<tr class="odd">

<th scope="col" abbr="id">Id
<input type="checkbox" name="option1" value="author"/>
</th>
<th scope="col" abbr="state">Title</th>	
<th scope="col" abbr="category">Description</th>
<th scope="col" abbr="title">Section</th>
<th scope="col" abbr="activation">Created date</th>	
<th scope="col" abbr="publish">Publish</th>
<th scope="col" abbr="delete">Delete</th>
<th scope="col" abbr="views">ID</th>



</tr>	
</thead>
<tbody>
<?php foreach($categories as $category){ ?>
<tr class="odd">
<th scope="row" class="column1">
<input type="checkbox" name="option1" value="author"/>
</th>
<td><?php echo $category->title; ?></td>
<td><?php echo $category->description; ?></td>
<td><?php echo $categories_model->getSectionName($category->parent_id); ?></td>
<td><?php echo $category->created; ?></td>
<td>Publish/unpublish</td>
<td>Delete</td>
<td><?php echo $category->id; ?></td>
</tr>
<?php } ?>	
 <!--<tr class="odd">

<th scope="row" class="column1">test
<input type="checkbox" name="option1" value="author"/>
</th>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
</tr>	
<tr>

<th scope="row" class="column1">test
<input type="checkbox" name="option1" value="author"/>

</th>	
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
</tr>	
<tr class="odd">

<th scope="row" class="column1">test
<input type="checkbox" name="option1" value="author"/>

</th>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
</tr>	
<tr>

<th scope="row" class="column1">test
<input type="checkbox" name="option1" value="author"/>

</th>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
</tr>	


<tr class="odd">

<th scope="row" class="column1">test
<input type="checkbox" name="option1" value="author"/>

</th>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
</tr>	
<tr>
<th scope="row" class="column1">test
<input type="checkbox" name="option1" value="author"/>
</th>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
</tr>	
<tr class="odd">
<th scope="row" class="column1">test
<input type="checkbox" name="option1" value="author"/>
</th>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
</tr>	
<tr>
<th scope="row" class="column1">test
<input type="checkbox" name="option1" value="author"/>
</th>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>

</tr>	
<tr class="odd">
<th scope="row" class="column1">test
<input type="checkbox" name="option1" value="author"/>
</th>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
</tr>	
<tr>

<th scope="row" class="column1">test
<input type="checkbox" name="option1" value="author"/>
</th>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
</tr>
<tr class="odd">
<th scope="row" class="column1">test
<input type="checkbox" name="option1" value="author"/>

</th>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
</tr>	
<tr>
<th scope="row" class="column1">test
<input type="checkbox" name="option1" value="author"/>
</th>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
</tr>	
<tr class="odd">
<th scope="row" class="column1">test
<input type="checkbox" name="option1" value="author"/>

</th>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>

</tr>	
<tr>
<th scope="row" class="column1">test
<input type="checkbox" name="option1" value="author"/>

</th>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
<td>Test</td>
</tr>-->
</tbody>

</table>
<!-- end table -->

<!-- start pagination -->

<div class="pagination">
<ul>
<li><a href="#" class="prevnext disablelink">« previous</a></li>
<li><a href="#" class="currentpage">1</a></li>
<li><a href="#">2</a></li>
<li><a href="#">3</a></li>
<li><a href="#">4</a></li>
<li><a href="#">5</a></li>
<li><a href="#">6</a></li>
<li><a href="#">7</a></li>
<li><a href="#">8</a></li>
<li><a href="#">9</a>...</li>
<li><a href="#">15</a></li>
<li><a href="#">16</a></li>
<li><a href="#" class="prevnext">next »</a></li>
</ul>
</div>
<!-- end pagination -->

</div>
<!-- end holder_content -->


</div>
<!-- end container -->
