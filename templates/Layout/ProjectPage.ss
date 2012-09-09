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
						<th>One liner</th>
						<th>Requested by</th>
                        <th>Status</th>
                        
						<th>%Complete</th>
                    </tr>
                </thead>
                <tbody>
                <% loop oldProjects %>
                    <tr>
                        <td>
                            <a href="$Link">$Title</a>
                        </td> 
						<td>
                           $ShortDescription
                        </td> 
                        
                        <td>
                           $Requester.FirstName
                        </td>
						<td>
                           $Status
                        </td>    
						<td><% if $PercentComplete %>$PercentComplete<% else %>Not Started<% end_if %>
                        </td>
                    </tr>
                <% end_loop %>
                </tbody>
                </table>
		
		</div>
		
		
		
		
</div>
