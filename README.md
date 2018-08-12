# rest_api_mongoDB
Rest Api/UI with MongoDB en Laravel
<h1 align="center">REST web service of a TO DO list</h1>

<h2>About</h2>

<ul>
<h3>The api should perform:</h3>
<li>Create a new task </li>
<li>Update a task </li>
<li>Delete a task. </li>
<li>Show a task by id</li>
<li>List all tasks: </li>
<ul>


<li>Should be able to filter tasks by due date, </li>
<li>completed and uncompleted, </li>
<li>date of creation,  </li>
<li>date of update.</li>
<liThe response, must be paginated showing only 5 results per page.</li>
<li>Define one filter (sort direction and data column) as default and </li> 
<li>apply the required logic to cache the list of items (be sure to prevent showing stale data)</li>
</ul>	
</ul>
<ul>
<h3>Using</h3>
<li>use MongoDB as database</li>
<li>The list of all result must be cached with Redis or Memcached</li>
</ul>

<h3>Task Schema:</h3>

<p>_id         [id]</p>
<p>title       [string] (required)</p>
<p>description [string]</p>
<p>due_date    [datetime] (required)</p>
<p>completed   [boolean] (default: false)</p>
<p>created_at  [datetime]</p>
<p>updated_at  [datetime]</p>
