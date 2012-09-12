<div class="content-container typography">	
<div>


		<% loop Task %>
		<div class="TheTask">
			<h1>$Title </h1>
			<h4>Task for <a href=$Project.Link>$Project.Title</a></h4>
			<div class="TaskDesc">$Description</div>
			<ul>
				<li>Due Date: <strong><% if DueDate %>$DueDate.Long<% end_if %></strong></li>
				<li>Status: <strong><% if Status %>$Status<% end_if %></strong></li>
				<li>Hours Worked:  <strong>$HoursWorked</strong></li>
				
			</ul>
		</div>
		<div id="formblock">
			
			$Up.addWorkForm
		</div>
		<div id="Tasks">
			<h3>Work Logs</h3>
			<table class="standard">
                <thead>
                    <tr>
                        <th>Date</th>
						<th>Title</th>
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
                           $Title
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
                           Sorry no work logs yet.
                      </td>
                    </tr>
				<% end_if %>
                </tbody>
              </table>
		</div>
		<% end_loop %>
		
<div class="clear"></div>
</div>
<% include SideBar %>