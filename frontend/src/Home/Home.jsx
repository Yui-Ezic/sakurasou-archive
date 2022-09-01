import React from 'react';
import './Home.css';

function App() {
    return (
        <form action="http://localhost:8081/storage/image/upload" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload"/>
            <input type="submit" value="Upload Image" name="submit"/>
        </form>
    );
}

export default App;
