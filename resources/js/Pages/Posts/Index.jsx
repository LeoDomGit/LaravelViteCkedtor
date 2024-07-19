import React, { useState } from "react";
import Layout from "../../components/Layout";
import { Dropzone, FileMosaic } from "@dropzone-ui/react";
import CKEditor from "../../components/CKEditor";
import Switch from '@mui/material/Switch';
import FormControlLabel from '@mui/material/FormControlLabel';
function Index({ cates }) {
    const [title, setTitle] = useState("");
    const [datacate, setDataCate] = useState(cates);
    const [create, setCreate] = useState(false);
    const [summary, setSummary] = useState("");
    const [content, setContent] = useState("");
    const [categories, setCategories] = useState(cates);
    const [files, setFiles] = React.useState([]);
    const [status, setStatus] = React.useState(true);

    const handleChange = (event) => {
        setStatus(event.target.checked);
    };
    const updateFiles = (incommingFiles) => {
        setFiles(incommingFiles);
    };
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
                                <div className="input-group mb-3">
                                    <span
                                        className="input-group-text"
                                        id="basic-addon1"
                                    >
                                        Nhóm bài viết
                                    </span>
                                    <select
                                        name=""
                                        className="form-control"
                                        id=""
                                    >
                                        <option value="0">
                                            Chọn loại bài viết
                                        </option>
                                        {datacate.length > 0 &&
                                            datacate.map((item, index) => (
                                                <option value={item.id}>
                                                    {item.name}
                                                </option>
                                            ))}
                                    </select>
                                </div>
                                <div className="row mb-3">
                                    <div className="col-md-4 ">
                                    <Dropzone
                                        onChange={updateFiles}
                                        value={files}
                                    >
                                        {files.map((file) => (
                                            <FileMosaic {...file} preview />
                                        ))}
                                    </Dropzone>
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-md">
                                        <CKEditor />
                                    </div>
                                </div>
                            </div>
                            <div className="card-footer">
                                <div className="row">
                                    <div className="col-md-8">
                                    <FormControlLabel control={<Switch />} label="Trạng thái" />
                                    <FormControlLabel control={<Switch />} label="Highlight" />

                                    </div>
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
