@include('includes.header')
@include('components.navbar')
    <section class="p-5 text-center">
        <h6>A simple tool to monitor your Electricity and Water usage.</h6>
        <p>Please register to make use of this tool.</p>
        <p><strong>Some Notes:</strong></p>
        <ul class="list-group" style="width: 50%; margin-left: 25%;">
            <li class="list-group-item">You first need to add your address as a house.</li>
            <li class="list-group-item">This will be used for saving data to the database.</li>
            <li class="list-group-item">If you ever move, you can add the new house as a 2nd house, if you wanted.</li>
        </ul>

        <a href="/register" class="btn btn-primary mt-2">Register Now</a>
    </section>
@include('includes.footer')