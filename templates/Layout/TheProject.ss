<div class="content-container typography">	
<article>
<h1>$Title</h1>
<div class="content">$Content</div>
</article>
		<% loop Project %>
		<div class="TheProject">
		
			
			<table id="overviewtable">
				<tr>
				<th>ORIGINAL HOURS ESTIMATED:</th>
				<td>$getOriginalHoursEstimated</td>
				</tr>
				<tr>
				<th>HOURS WORKED:</th>
				<td>$getTotalHoursWorked </td>
				</tr>
				<tr>
				<th>ESTIMATED HOURS REMAINING:</th>
				<td>$getTotalHoursEstimated</td>
				</tr>
				<tr>
				<th>PROJECT COMPLETION:</th>
				<td>
				$PercentComplete
				({$TotalHoursWorked} /{$TotalHoursEstimatedAndWorked})
				</td>
				</tr>
			</table>
			<table id="controls">
			<tr>
				<% if Status = "Awaiting-Approval" %><td >$Up.approveForm<% else %><td class="green">Approved<% end_if %></td
			</tr>
			<tr>
				<td><a href="$eLink">Edit</a></td
			</tr>
			<tr>
				<td><a href="add-task">Add Task</a></td
			</tr>
		</table>
			<h2>$Title</h2>
			<h3>For $Requester.FirstName $Requester.Surname ext: $Requester.DefaultNum</h3>
			
			
			<p>The one liner: <strong> $ShortDescription</strong> </p>
				<div class="clear"></div>
				<div class="lhalf">
					<p >$Description </p>
					
				</div>
				<div class="rhalf">
					


						<% loop ProjectScore.GroupedBy(SClassName) %>
						<table>
						<tr>
							<th colspan=2 class="title">$SClassName</th>
						</tr>
							
							 <% loop Children %>
							 <tr>
								<th>$STitle</th>
								<% if Score=1 %><td class="red">Yes <% else %><td>No<% end_if %></td>
							</tr>
															
							<% end_loop %>
						</table>
							
							
					<% end_loop %>


					
					
				<div class="info">	
					
					
						<table>
						<tr>
							<th colspan=2 class="title">Impacts</th>
						</tr>
							<% loop TheImpact %>
							 
							 <tr>
								<th>$ITitle</th>
								<% if Impact=1 %><td class="red">Yes <% else %><td>No<% end_if %></td>
							</tr>
															
							<% end_loop %>
						</table>
							<h3>Project Info.</h3>
							
					
				<ul>
					<li>Due Date: <strong><% if DueDate %>$DueDate.Long<% end_if %></strong></li>
					<li>Status: <strong><% if Status %>$Status<% end_if %></strong></li>
					<li>Type: <strong><% if Type %>$Type<% end_if %></strong></li>
					<li>Priority: <strong><% if Priority %>$Priority<% end_if %></strong></li>
					<li>Hours Worked: <strong>$TotalHoursWorked</strong></li>
					<li>Project Score: <strong>$TheScores</strong></li>
					
				</ul>
				<p>Project Contact: $Owner.FirstName ext: $Owner.DefaultNum</p>
				</div>
			</div>
				
				
				
			<div id="Tasks">
			<h3>Tasks</h3>
			<table class="standard">
                <thead>
                    <tr>
                        <th>Task</th>
						<th>Due Date</th>
                        <th>Status</th>
                        <th>Hours</th>
                    </tr>
                </thead>
                <tbody>
               <% if Tasks %>
			    	<% loop Tasks %>
                   <% if bak %>
				    <tr >
                        <td class="comp">
                           <a href="$Link">$Title</a>
                        </td> 
						<td class="comp">
                           $Description
                        </td> 
						
                        <td class="comp">$Status</td>
						<td class="comp">Worked: $HoursWorked <br />
							Remaining: $EstimatedHoursRemaining
                          
                        </td>
                    </tr>
					<% else %>
						<% if bak1 %>
						<tr class="late">
							<td>
							   <a href="$Link">$Title</a>
							</td> 
							<td >
							   $DueDate.Nice
							</td> 
							<td >$Status</td>
							 <td>Worked: $HoursWorked <br />
								Remaining: $EstimatedHoursRemaining
							 </td>
						</tr>
						<% else %>
						
						<tr>
							<td>
							   <a href="$Link">$Title</a>
							</td> 
							<td >
							   $DueDate.Nice
							</td> 
							<td >$Status</td>
							 <td>Worked: $HoursWorked <br />
								Remaining: $EstimatedHoursRemaining
							 </td>
						</tr>
						<% end_if %>
					<% end_if %>
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
			</div>
				
		</div>
		
		<% end_loop %>
		<hr />
		$addTaskForm
		
<div class="clear"></div>

