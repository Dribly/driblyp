'use strict';
import React, {Component} from 'react'
import update from 'immutability-helper';

class TapPage extends Component {

    constructor(props) {
        super(props);
        this.morningHours = [7, 8, 9, 10, 11];
        this.daytimeHours = [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17];
        this.afternoontimeHours = [12, 13, 14, 15, 16, 17];
        this.eveningtimeHours = [18, 19, 20, 21];
        this.nighttimeHours = [22, 23, 0, 1, 2, 3, 4, 5, 6];
        this.morningsRange = [this.morningHours, this.morningHours, this.morningHours, this.morningHours, this.morningHours, this.morningHours, this.morningHours];
        this.daysRange = [this.daytimeHours, this.daytimeHours, this.daytimeHours, this.daytimeHours, this.daytimeHours, this.daytimeHours, this.daytimeHours];
        this.afternoonsRange = [this.afternoontimeHours, this.afternoontimeHours, this.afternoontimeHours, this.afternoontimeHours, this.afternoontimeHours, this.afternoontimeHours, this.afternoontimeHours];
        this.eveningsRange = [this.eveningtimeHours, this.eveningtimeHours, this.eveningtimeHours, this.eveningtimeHours, this.eveningtimeHours, this.eveningtimeHours, this.eveningtimeHours];
        this.overnightsRange = [this.nighttimeHours, this.nighttimeHours, this.nighttimeHours, this.nighttimeHours, this.nighttimeHours, this.nighttimeHours, this.nighttimeHours];
        // this.state.slots = this.props.slots
        this.state = {isDirty: false};
    }

    componentDidMount() {
        this.fetchSlots()
    }

    fetchSlots() {
        if (parseInt(this.props.tapId, 10) > 0) {
            fetch("/json/taps/" + this.props.tapId + "/timeslots", {
                headers: {
                    "Accept": "Application/json"
                },
                credentials: 'same-origin'
                // referrer: "*client", // no-referrer, *client
            })
                .then(res => res.json())
                .then(
                    (result) => {
                        this.setState({
                            isLoaded: true,
                            slots: result.slots
                        });

                    },
                    // Note: it's important to handle errors here
                    // instead of a catch() block so that we don't swallow
                    // exceptions from actual bugs in components.
                    (error) => {
                        this.setState({
                            isLoaded: true,
                            error
                        });
                    }
                )
        } else {
            this.setState({error: "No ID"})
        }
    }

    renderSlotElement(keyIndex, elem) {
        if (elem) {
            return <span key={keyIndex} className="tap_off">X</span>
        } else {
            return <span key={keyIndex} className="tap_on">-</span>
        }
    }

    renderDaySet(hours) {
        let result = []
        for (let i = 0; i < 24; i++) {
            result.push(this.renderSlotElement(i, hours[i]))
        }
        return result
    }

    makeDayRow(slots) {
        let daysOfWeek = {0: 'Mon', 1: 'Tue', 2: 'Wed', 3: 'Thu', 4: 'Fri', 5: 'Sat', 6: 'Sun'}
        let result = []
        for (let day = 0; day < 7; day++) {
            result.push(<div className="row" key={day}>
                <div className="col-lg-3 slot-dayname">{daysOfWeek[day]}</div>
                <div className="col-lg-9">
                    {this.renderDaySet(slots[day])}
                </div>
            </div>)
        }
        return result
    }

    changeValues(valueSet, newValue) {
        let stateModel = this.state;
        let changeSet = [];
        this.state.isDirty = true;
        for (let day = 0; day < 7; day++) {
            valueSet[day].map((hourToChange) => (
                stateModel.slots[day][hourToChange] = newValue))
        }
        this.setState(stateModel)
    }

    componentDidUpdate(prevProps) {
        if (this.state.isDirty) {
            fetch('/taps/' + this.props.tapId + '/storeTimeSlots', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.props.csrf,
                },
                body: JSON.stringify({
                    slots: this.state.slots,
                })
            })
            this.setState({isDirty: false});// for
        }
    }

    render() {

        const {error, isLoaded, slots} = this.state;
        if (error) {
            return <div className="card-body">Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div className="card-body">Loading...</div>;
        } else {
            let dayBlock = this.makeDayRow(slots)
            return (
                <div className="card">
                    <div className="card-header  card-header-success">
                        <h4 className="card-title">Timer Blocks</h4>
                    </div>
                    <div className="card-body">
                        <div className="row">
                            <div className="col-lg-12">
                                <h4>Choose which slots to disable this tap from Dribly.</h4>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-lg-3">
                                <h4>Block</h4>
                                <button value="Mornings"
                                        onClick={() => this.changeValues(this.morningsRange, true)}>Mornings
                                </button>
                                <button value="Daytimes"
                                        onClick={() => this.changeValues(this.daysRange, true)}>Daytimes
                                </button>
                                <button value="Afternoons"
                                        onClick={() => this.changeValues(this.afternoonsRange, true)}>Afternoons
                                </button>
                                <button value="Evenings"
                                        onClick={() => this.changeValues(this.eveningsRange, true)}>Evenings
                                </button>
                                <button value="Overnight"
                                        onClick={() => this.changeValues(this.overnightsRange, true)}>Overnight
                                </button>
                            </div>
                            <div className="col-lg-3">
                                <h4>Un Block</h4>
                                <button value="Mornings"
                                        onClick={() => this.changeValues(this.morningsRange, false)}>Mornings
                                </button>
                                <button value="Afternoons"
                                        onClick={() => this.changeValues(this.afternoonsRange, false)}>Afternoons
                                </button>
                                <button value="Daytimes"
                                        onClick={() => this.changeValues(this.daysRange, false)}>Daytimes
                                </button>
                                <button value="Evenings"
                                        onClick={() => this.changeValues(this.eveningsRange, false)}>Evenings
                                </button>
                                <button value="Overnight"
                                        onClick={() => this.changeValues(this.overnightsRange, false)}>Overnight
                                </button>
                            </div>
                            <div className="col-lg-6">
                                {dayBlock}
                            </div>
                        </div>
                    </div>
                </div>
            );
        }
    }
}

export default TapPage