import React, { useState, useEffect, Fragment } from "react";
import { cusaxios } from "../config";
import Loader from "../Loader/Loader";
import {
    BarChart,
    Bar,
    Cell,
    XAxis,
    YAxis,
    CartesianGrid,
    Tooltip,
    Legend,
    ResponsiveContainer,
} from "recharts";

const Statistics = () => {
    const curYear = new Date().getFullYear();
    const preYear = curYear - 1;
    const [firstYear, setFirstYear] = useState(curYear.toString());
    const [secondYear, setSecondYear] = useState(preYear.toString());
    const [stuCountData, setStuCountData] = useState();
    const [totalFirstYear, setTotalFirstYear] = useState();
    const [totalSecondYear, setTotalSecondYear] = useState();
    const [load, setLoad] = useState(false);
    const d = new Date();
    var years = [];
    for (let i = 2000; i <= d.getFullYear(); i++) {
        years.push(i);
    }

    // data request
    const getData = () => {
        setLoad(true);
        cusaxios
            .get(
                `/admin-mod/get-data?firstYear=${firstYear}&secondYear=${secondYear}`
            )
            .then(({ data }) => {
                var { data } = data;
                setLoad(false);
                setStuCountData(data.data);
                setTotalFirstYear(data.totalFirstYear);
                setTotalSecondYear(data.totalSecondYear);
            });
    };

    useEffect(() => {
        getData();
    }, [firstYear, secondYear]);

    return (
        <Fragment>
            {load && (
                <div className="row">
                    <div className="col-sm-12">
                        <center>
                            <Loader />
                        </center>
                    </div>
                </div>
            )}
            {!load && (
                <Fragment>
                    <div className="row">
                        <div className="col-sm-3 mt-4 text-white">
                            <label htmlFor="">Choose First Year</label>
                            <select
                                className="form-select text-center"
                                aria-label="Default select example"
                                value={firstYear}
                                onChange={(e) => {
                                    setFirstYear(e.target.value);
                                }}
                            >
                                {years.reverse().map((y, i) => (
                                    <option key={i} value={y}>
                                        {y}
                                    </option>
                                ))}
                            </select>
                        </div>
                        <div className="col-sm-3 mt-4 text-white">
                            <label htmlFor="">Choose Second Year</label>
                            <select
                                className="form-select text-center"
                                aria-label="Default select example"
                                value={secondYear}
                                onChange={(e) => {
                                    setSecondYear(e.target.value);
                                }}
                            >
                                {years.map((y, i) => (
                                    <option key={i} value={y}>
                                        {y}
                                    </option>
                                ))}
                            </select>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-sm-12 mt-4">
                            <h5 className="text-white text-center">Number of students joined yearly</h5>
                            <h6 className="text-white text-center">
                                Total students joined in {firstYear} : {totalFirstYear}
                            </h6>
                            <h6 className="text-white text-center">
                                Total students joined in {secondYear} : {totalSecondYear}
                            </h6>
                        </div>
                        <div className="col-sm-12">
                            <div
                                className="rounded container"
                                style={{ backgroundColor: "white" }}
                            >
                                <ResponsiveContainer width="100%" aspect={3}>
                                    <BarChart
                                        width={150}
                                        height={40}
                                        data={stuCountData}
                                    >
                                        <CartesianGrid strokeDasharray="3 3" />
                                        <XAxis dataKey="name" />
                                        <YAxis />
                                        <Tooltip />
                                        <Legend />
                                        <Bar
                                            dataKey={firstYear}
                                            fill="#FF8F00"
                                        />
                                        <Bar
                                            dataKey={secondYear}
                                            fill="#8884d8"
                                        />
                                    </BarChart>
                                </ResponsiveContainer>
                            </div>
                        </div>
                    </div>
                </Fragment>
            )}
        </Fragment>
    );
};

export default Statistics;
