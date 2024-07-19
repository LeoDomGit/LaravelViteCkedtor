import React, { useState } from "react";
import Layout from "../../components/Layout";

function Index({ cates }) {
    const [title,setTitle]= useState('');
    const [summary,setSummary]= useState('');
    const [categories,setCategories]= useState(cates);
    return (
        <Layout>
            <>
                <div className="row">
                    <div className="col-md-3">
                        <button className="btn btn-primary">Thêm</button>
                    </div>
                </div>
                <div className="row mt-3">
                    <div className="col-md-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <div className="input-group mb-3">
                                    <span
                                        className="input-group-text"
                                        id="basic-addon1"
                                    >
                                        Tiêu đề
                                    </span>
                                    <input
                                        type="text"
                                        className="form-control"
                                        placeholder="Tiêu đề"
                                        aria-label="Tiêu đề"
                                        aria-describedby="basic-addon1"
                                    />
                                </div>
                                <div className="input-group mb-3">
                                    <span
                                        className="input-group-text"
                                        id="basic-addon1"
                                    >
                                        Tóm tắt
                                    </span>
                                    <input
                                        type="text"
                                        className="form-control"
                                        placeholder="Tóm tắt"
                                        aria-label="Tóm tắt"
                                        aria-describedby="basic-addon1"
                                    />
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </>
        </Layout>
    );
}

export default Index;
