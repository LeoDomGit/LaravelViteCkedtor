import React, { useState } from 'react'
import Layout from '../../components/Layout';

function Index({dataSlides}) {
    const [slides,setSlides]= useState([]);
    const [create,setCreate]= useState(false);
  return (
    <Layout>
    <>
    <div className="row">
    .<div class="card text-start">
        <div class="card-body">
            <h4 class="card-title">Title</h4>
            <p class="card-text">Body</p>
        </div>
    </div>
    
    </div>
    </>


    </Layout>
  )
}

export default Index