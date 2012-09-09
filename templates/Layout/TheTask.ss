<div class="content-container typography">	
<article>
<h1>$Title</h1>
<div class="content">$Content</div>
</article>
		<% loop Task %>
		<div class="TheProject">
		
			
			
			<h2>$Title </h2>
			<h3>Task for <a href=$Project.Link>$Project.Title</a></h3>
			<ul>
				<li>Due Date: <strong><% if DueDate %>$DueDate.Long<% end_if %></strong></li>
				<li>Status: <strong><% if Status %>$Status<% end_if %></strong></li>
				<li>Hours Worked:  <strong>$HoursWorked</strong></li>
				
			</ul>
			
		
			</div>
			<div id="Tasks">
			<h3>Tasks</h3>
			<table class="standard">
                <thead>
                    <tr>
                        <th>Task</th>
						<th>Hours Spent</th>
                        <th>Est. Hours Remaining</th>
                        
                    </tr>
                </thead>
                <tbody>
               <% if WorkLogs %>
			    	<% loop WorkLogs %>
                    <tr>
                        <td>
                           $Date.Nice
                        </td> 
						<td>
                           $HoursSpent
                        </td> 
                        <td>
                           $EstimatedHoursRemaining
                        </td>    
                        
                    </tr>
					<% end_loop %>
				<% else %>
				<tr>
                      
                        <td colspan=4>
                           Sorry no tasks yet.
                        </td>
                    </tr>
				<% end_if %>
                
                </tbody>
                </table>
			</dive>
				
		</div>
		<% end_loop %>
		
<div class="clear"></div>
</div>
<% include SideBar %>