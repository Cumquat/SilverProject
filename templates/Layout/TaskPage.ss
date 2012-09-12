<div class="content-container typography">	
	<article>
		<h1>$Title</h1>
		<div class="content">$Content</div>
	</article>
		<div id="grid">
		
			<table class="standard">
                <thead>
                    <tr>
                        <th>Title</th>
						<th>Project</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <% loop Tasks %>
                   <% if bak %>
				   
				    <tr>
                        <td class="comp">
                            <a href="$Link">$Title</a>
                        </td> 
						<td class="comp">
                           $Project.Title
                        </td> 
                        <td class="comp">
                           $Status
                        </td>    
                        <td class="comp">
                           $DueDate.Nice
                        </td>
                    
                    </tr>
					<% else %>
					<% if bak1 %>
						 <tr class="late">
                        <td >
                            <a href="$Link">$Title</a>
                        </td> 
						<td >
                           $Project.Title
                        </td> 
                        <td >
                           $Status
                        </td>    
                        <td >
                           $DueDate.Nice
                        </td>
                    
                    </tr>
						<% else %>
						
						 <tr>
                        <td >
                            <a href="$Link">$Title</a>
                        </td> 
						<td >
                           $Project.Title
                        </td> 
                        <td >
                           $Status
                        </td>    
                        <td >
                           $DueDate.Nice
                        </td>
                    
                    </tr>
						<% end_if %>
					<% end_if %>
                <% end_loop %>
                </tbody>
                </table>
		
		</div>
		
		$addtaskForm
		
		
</div>
