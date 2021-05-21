<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($projects as $project)
        <tr>
            <td>{{ $project->name }}</td>
            <td>{{ $project->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
