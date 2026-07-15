from rasa_sdk import Action, Tracker
from rasa_sdk.executor import CollectingDispatcher
from rasa_sdk.events import SlotSet

class ActionSetContext(Action):
    def name(self):
        return "action_set_context"

    def run(self, dispatcher, tracker, domain):
        intent = tracker.latest_message['intent'].get('name')
        if intent in ['registration', 'login','search_tutor']:
            return [SlotSet("user_context", intent)]
        return []

class ActionResetContext(Action):
    def name(self):
        return "action_reset_context"

    def run(self, dispatcher, tracker, domain):
        return [SlotSet("user_context", None)]
