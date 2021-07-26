@include('includes.header')
@include('components.navbar')
    <section class="p-5 text-center">
        <h6>A simple tool to monitor your Electricity and Water usage.</h6>
        <p>Please register to make use of this tool.</p>
        <p><strong>Some Notes:</strong></p>
        <div class="row">
            <div class="col-sm"></div>
            <div class="col-sm">
                <ul class="list-group">
                    <li class="list-group-item">You first need to add your address as a house.</li>
                    <li class="list-group-item">This will be used for saving data to the database.</li>
                    <li class="list-group-item">Before you can start entering data, you do need to enter a starting reading, even if it is just 0.</li>
                    <li class="list-group-item">If you ever move, you can add the new house as a 2nd house, if you wanted.</li>
                    <li class="list-group-item">For more information or if you have a suggestion, please contact me on <strong>support@metermonitor.co.za</strong></li>
                </ul>
            </div>
            <div class="col-sm"></div>
        </div>

        <a href="/register" class="btn btn-primary mt-2">Register Now</a>
    </section>
@include('includes.footer')