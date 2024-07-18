import axios from "axios";
import React, { useEffect, useState } from "react";
import Layout from "../../components/Layout";
import { Notyf } from "notyf";
import { Box, Switch, Typography } from "@mui/material";
import "notyf/notyf.min.css";
import CKEditor from "../../components/CKEditor";
import { DataGrid, GridToolbar } from "@mui/x-data-grid";
function Index() {
    const [page, setPage] = useState("");
    const [staticpage, setStatic] = useState(1);
    const [content, setContent] = useState("");
    const [url, setUrl] = useState("");
    const [create, setCreate] = useState(false);
    return (
        <>
            <Layout>
                <div className="row mb-3">
                    <div className="col-md-3">
                    <button className="btn btn-primary">Tạo</button>

                    </div>
                </div>
                <div className="row">
                    <div className="col-md-4">
                        <div className="input-group mb-3">
                            <span
                                className="input-group-text"
                                id="basic-addon1"
                            >
                                Tên trang
                            </span>
                            <input
                                type="text"
                                className="form-control"
                                placeholder="Tên trang"
                                aria-label="Tên trang"
                                aria-describedby="basic-addon1"
                            />
                        </div>
                    </div>
                    <div className="col-md-4">
                        <div className="input-group mb-3">
                            <span
                                className="input-group-text"
                                id="basic-addon1"
                            >
                                URL
                            </span>
                            <input
                                type="text"
                                className="form-control"
                                placeholder="URL ..."
                                aria-label="URL ..."
                                aria-describedby="basic-addon1"
                            />
                        </div>
                    </div>
                </div>
            </Layout>
        </>
    );
}

export default Index;
